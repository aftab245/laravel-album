<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{

    protected $fillable = [
        'user_id', 'name', 'description', 'meta', 'size', 'parent_id',
    ];
    // protected $table = "directory";

    public function parent()
    {
        return $this->belongsTo('App\Directory');
    }

    public function directories()
    {
        return $this->hasMany('App\Directory', 'parent_id');
    }

    public function files()
    {
        return $this->hasMany('App\File', 'parent_id');
    }

}