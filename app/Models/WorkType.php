<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    protected $fillable = [ //fungsinya untuk user dapat mengisi table
        'type',
        'provision_text_before',
        'provision_text_after'
    ];
    
}
