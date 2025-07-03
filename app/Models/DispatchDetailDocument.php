<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchDetailDocument extends Model
{
    public function dispatchDetail()
    {
        return $this->belongsTo(DispatchDetail::class);
    }

}
