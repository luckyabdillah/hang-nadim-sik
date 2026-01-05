<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
                $data = $request->only(['name', 'vendor_name', 'email', 'password', 'password_confirmation']);

                $validator = Validator::make($data, [
                    'name' => 'required|string|min:3|max:255',
                    'vendor_name' => 'required|string|min:3|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8|confirmed',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 422);
                }

                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'user_type' => 'external',
                ]);

                Vendor::create([
                    'user_id' => $user->id,
                    'legal_name' => $data['vendor_name'],
                ]);
                
                DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Could not register user'], 500);
        }

        return response()->json([
            'statusCode' => 201,
            'message' => 'User registered successfully',
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = auth()->attempt($credentials);

            if (! $user) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            // Ambil user
            $user = auth()->user();

            // Custom claims: role & permissions
            $customClaims = [
                'role' => $user->role->name,
                'permissions' => $user->role->permissions->pluck('name')->toArray(),
            ];

            $token = JWTAuth::claims($customClaims)->attempt($credentials);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], 500);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()->getJWTCustomClaims(),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => auth()->user()->getJWTCustomClaims()]);
    }

    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
            }
        } catch (JWTException $e) {
            // ignore
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => __($status)]);
        }

        return response()->json(['message' => __($status)], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password = Hash::make($password);
                $user->setRememberToken(Str::random(60));
                $user->save();

                // event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            $user = User::where('email', $request->email)->first();
            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => __($status), 'access_token' => $token, 'token_type' => 'bearer']);
        }

        return response()->json(['message' => __($status)], 400);
    }
}
