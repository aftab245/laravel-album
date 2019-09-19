<?php

namespace App\Http\Controllers;

class FolderController extends Controller
{
    public function create_album($album_id)
    {
        return view('child.creata')->with('album_id', $album_id);
    }
}