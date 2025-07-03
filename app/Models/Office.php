<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    //public function users(){
    //
    //    return $this->hasMany(User::class);
    //}
public function dispatchs(){
    return $this->hasMany(Dispatch::class);
}
}
