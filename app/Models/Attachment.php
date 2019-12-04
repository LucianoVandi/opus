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
    //
    public function attachable(){
        return $this->morphTo();
    }
}
