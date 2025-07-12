<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchDetailDocument extends Model
{
    protected $fillable = [
        'dispatch_detail_id', // Add this
        'title',
        'file',
        'status',
    ];
    public function dispatchDetail()
    {
        return $this->belongsTo(DispatchDetail::class);
    }

}
