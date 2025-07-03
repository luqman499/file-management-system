<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    public function dispatchs(){

    return $this->hasMany(Dispatch::class);
}
}
