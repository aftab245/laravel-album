<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($directory_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'photo' => 'image',
        ]);
        $fileNameWithExt = $request->file('photo')->getClientOriginalName();
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $extension = $extension ? $extension : 'png';
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
        $file->size = $request->file('photo')->getClientSize();
        $file->save();
        return response()->json([
            'success' => true,
            'data' => $file,
        ]);

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        return response()->json($file, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->get("id")) {
            return response()->json(["message" => 'please provide a valid id']);
        }

        try {
            $file = File::find($request->get("id"));
            if (!$file) {
                return response()->json(["message" => 'Record does\'t exist']);
            }

            $file->delete();
            return response()->json('data deleted', 200);

        } catch (\Throwable $th) {
            return response()->json('delete failed', 500);
        }

    }
}