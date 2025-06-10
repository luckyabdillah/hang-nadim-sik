<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStage extends Model
{
    protected $guarded = ['id'];

    public function workPermitLetter()
    {
        return $this->belongsTo(WorkPermitLetter::class);
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class);
    }
}
