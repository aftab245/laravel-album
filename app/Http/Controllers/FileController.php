<?php

namespace App\Http\Controllers;

class FileController extends Controller
{
    public function create_album($album_id)
    {
        return view('child.creatp')->with('album_id', $album_id);
    }
}