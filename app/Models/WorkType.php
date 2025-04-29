<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkType extends Model
{
    use SoftDeletes;
    
    protected $fillable = [ //fungsinya untuk user dapat mengisi table
        'type',
        'unit_name',
        'provision_text_before',
        'provision_text_after'
    ];
    
}
