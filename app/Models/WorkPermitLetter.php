<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WorkPermitLetter extends Model
{
    protected $guarded = ['id'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }

    public function workLocation()
    {
        return $this->belongsTo(WorkLocation::class);
    }

    public function approvalStages()
    {
        return $this->hasMany(ApprovalStage::class);
    }

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
