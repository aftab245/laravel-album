<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = [
        'parent_id', 'user_id', 'name', 'description', 'photo', 'hash', 'extention', 'file_name', 'size',
    ];
    public function parent()
    {
        return $this->belongsTo('Directory');
    }
}