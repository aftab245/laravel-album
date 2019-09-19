<?php

namespace App\Http\Controllers;

use App\Directory;
use App\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //   $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     *  getFileSystem
     */
    public function getFileSystem($directory_id = null)
    {
        if (!$directory_id) {
            $response = ["name" => "root", "path" => "/"];
            $response["directories"] = Directory::where('parent_id', null)->get();
            $response["files"] = File::where(["parent_id" => null])->get();
            return $response;
        }

        $response = Directory::with(["directories", "files", "parent"])->find($directory_id);

        return response()->json($response);
    }
}