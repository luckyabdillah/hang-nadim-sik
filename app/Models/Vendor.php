<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vendor extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'email',
        'address',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
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
