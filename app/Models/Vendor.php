<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'addres',
    ];
    
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
