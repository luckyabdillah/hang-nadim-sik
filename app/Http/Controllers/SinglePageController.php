<?php

namespace App\Http\Controllers;

use App\Models\WorkPermitLetter;
use Illuminate\Http\Request;

use Mail;
use App\Mail\ContactMail;

class SinglePageController extends Controller
{
   public function index()
    {
        return view('index');
    }

    public function workPermitLetter()
    {
        $workPermitLetters = WorkPermitLetter::with('vendor')->orderBy('started_at', 'desc')->paginate(10);

        return view('work-permit-letters', compact('workPermitLetters'));
    }

    public function contact()
    {
        return view('contact');
    }
    
    public function storeContact(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'whatsapp_number' => 'required|numeric|digits_between:8,20',
            'title' => 'required|max:100',
            'message' => 'required',
        ]);

        $mailDelivery = false;
        $mailAttemps = 0;
        // $mailInfo = 'info@bthairport.com';
        $mailInfo = 'tech@luckyabdillah.com';

        while (!$mailDelivery) {
            if ($mailAttemps >= 2) {
                break;
            }
            try {
                Mail::to($mailInfo)
                    ->cc($validatedData['email'])
                    ->send(new ContactMail($validatedData));
                
                $mailDelivery = true;
            } catch (\Throwable $th) {
                $mailAttemps += 1;
            }
        }

        if (!$mailDelivery) {
            return redirect()->back()->withInput()->with('failed', 'Failed while sending email, please try to submit again');
        }

        return redirect('/contact')->with('success', 'Message has been successfully sent');
    }
}
