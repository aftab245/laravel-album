<?php

namespace App\Http\Controllers;

use App\Directory;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($directory_id = null)
    {
        if (!$directory_id) {
            $response = ["name" => "root", "path" => "/"];
            $response["directories"] = Directory::where('parent_id', null)->get();
            $response["files"] = File::where(["parent_id" => null])->get();
            return view('tests.index')->with('response', $response);
        }

        $response = Directory::with(["directories", "files", "parent"])->find($directory_id);
        if (!$response) {return response()->json('Record not found');}
        return view('tests.show')->with('response', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_album()
    {
        return view('tests.create');
    }

    public function create_photo()
    {
        return view('tests.creat1');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_album(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
        ]);
        $size = DB::table('files')->where('parent_id', '=', 4)->sum('size');
        // return $size;
        $directory = new Directory();
        $directory->user_id = auth()->user()->id;
        $directory->name = $request->input('name');
        $directory->description = $request->input('description');
        $directory->meta = $request->input('meta');
        $directory->size = $request->input('size');
        $directory->parent_id = $request->input('parent_id');
        $directory->save();
        return redirect()->route('index_page')
            ->with('flash_message', 'Album
         ' . $directory->name . ' created');
    }

    public function store_photo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'photo' => 'image',
        ]);
        $fileNameWithExt = $request->file('photo')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $size = $request->file('photo')->getClientSize();

        $hash = md5($fileName);

        $split_hash = str_split($hash, 10);

        $fileNameToStore = $fileName . '-' . time() . '.' . $extension;

        $path = $request->file('photo')->storeAs('public/uploads/' . $split_hash['0'] . '/' . $split_hash['1'] .
            '/' . $split_hash['2'], $fileNameToStore);

        $file = new File();
        $file->parent_id = $request->input('parent_id');
        $file->user_id = auth()->user()->id;
        $file->name = $request->input('name');
        $file->description = $request->input('description');
        $file->photo = $fileNameToStore;
        $file->hash = $hash;
        $file->extention = $extension;
        $file->file_name = $fileName;
        $file->size = $size;
        $file->save();
        return redirect()->route('index_page')
            ->with('flash_message', 'Photo
         ' . $file->name . ' uploaded');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_album($id)
    {
        $directory = Directory::findOrFail($id);
        return view('tests.edita', compact('directory'));
    }

    public function edit_photo($id)
    {
        $file = File::findOrFail($id);
        return view('tests.editp', compact('file'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_album(Request $request, $id)
    {
        $directory = Directory::find($id);
        $directory->update($request->all());
        return redirect()->route('index_page')
            ->with('flash_message',
                'album successfully updated.');
    }
    public function update_photo(Request $request, $id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json(["message" => 'Record does\'t exist'], 404);
        }
        $fileNameWithExt = $request->file('photo')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $size = $request->file('photo')->getClientSize();
        $fileNameToStore = $fileName . '-' . time() . '.' . $extension;

        $hash = md5($fileName);

        $split_hash = str_split($hash, 10);

        $path = $request->file('photo')->storeAs('public/uploads/' . $split_hash['0'] . '/' . $split_hash['1'] .
            '/' . $split_hash['2'], $fileNameToStore);

        $data = ['parent_id' => $request->input('parent_id'), 'user_id' => auth()->user()->id,
            'name' => $request->input('name'), 'description' => $request->input('description'), 'hash' => $hash,
            'extention' => $extension, 'file_name' => $fileName, 'photo' => $fileNameToStore, 'size' => $size];
        $file->update($data);
        return redirect()->route('index_page')
            ->with('flash_message',
                'photo successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_album($id)
    {
        $directory = Directory::find($id);
        if (!$directory) {
            return response()->json('Not found', 404);
        }
        try {
            $directory->delete();
            return redirect()->route('index_page')
                ->with('flash_message',
                    'photo successfully deleted.');

        } catch (\Throwable $th) {
            $response = ["message" => "failed to delete", "status" => 500, "error" => $th];
            return response()
                ->json($this->makeResponse($response), 500);
        }

    }

    public function destroy_photo($id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json('Not found', 404);
        }
        try {
            $file->delete();
            return redirect()->route('index_page')
                ->with('flash_message',
                    'photo ' . $file->name . ' successfully deleted.');
        } catch (\Throwable $th) {
            $response = ["message" => "failed to delete", "status" => 500, "error" => $th];
            return response()
                ->json($this->makeResponse($response), 500);
        }

    }

}