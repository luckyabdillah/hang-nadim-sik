<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vendor extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'legal_name',
        'address',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating (function ($model) {
            if (empty($model->uuid)){
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
