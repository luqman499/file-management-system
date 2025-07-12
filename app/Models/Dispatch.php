<?php

namespace App\Models;
use App\Models\AttachmentFile;
use Illuminate\Database\Eloquent\Model;



class Dispatch extends Model
{
    protected $fillable = [
        'title',
        'flag_id',
        'office_id',
        'folder_id',
        'dispatch_number',
        'file_number',
        'date',
        'time',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function flag()
    {
        return $this->belongsTo(Flag::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

  public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dispatchDocuments(){
        return $this->hasMany(DispatchDocument::class);
    }

    public function dispatchDetails()
    {
        return $this->hasMany(DispatchDetail::class);
    }

}
