<?php

namespace App\Models;

use App\Models\User;
use App\Models\Dispatch;
use App\Models\DispatchDetailDocument;
use Illuminate\Database\Eloquent\Model;

class DispatchDetail extends Model
{
    protected $fillable = [
        'dispatch_id',
        'user_id',
        'status',
        'remarks',
    ];

    public function dispatch()
    {
        return $this->belongsTo(Dispatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dispatchDetailDocument()
    {
        return $this->hasMany(DispatchDetailDocument::class);
    }



     public function scopeOfAssignedToMe($query)
    {
         return $query->where('user_id', auth()->user()->id)->where('status',  0);
    }



 public function scopeOfApproved($query)
 {
     return $query->where('status', 1);
 }

 public function scopeRejected($query)
 {
     return $query->where('status', 2);
 }

 public function scopeReturned($query)
 {
     return $query->where('status', 3);
 }

 public function scopeRecommended($query)
 {
     return $query->where('status', 4);
 }

}

