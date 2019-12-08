<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{

    protected $fillable = [
        'name',
        'path',
        'mimetype',
        'user_id'
    ];

    protected $appends = [
        'file_icon'
    ];

    protected $mimeTypeToIcons = [
        'image/jpeg' => 'fa-file-image-o',
        'application/pdf' => 'fa-file-pdf-o',
        'application/msword' => 'fa-file-word-o',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fa-file-excel-o',
        'application/zip' => 'fa-file-archive-o',
        'application/mp3' => 'fa-file-audio-o',
        'application/mp4' => 'fa-file-video-o',
        '_default' => 'fa-paperclip'
    ];

    //
    public function attachable()
    {
        return $this->morphTo();
    }

    public function getFileIconAttribute()
    {
        return isset($this->mimeTypeToIcons[$this->mimetype]) 
            ? $this->mimeTypeToIcons[$this->mimetype]
            : $this->mimeTypeToIcons['_default'];
    }
}
