<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'level',
        'signature',
        'is_default_approver'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
