<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentFile extends Model
{
    use HasFactory;

    protected $fillable = ['file_name', 'file_path', 'dispatch_id'];

    public function dispatch()
    {
        return $this->belongsTo(Dispatch::class);
    }
}