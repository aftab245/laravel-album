<?php

namespace App\Http\Controllers;

use App\Directory;
use Illuminate\Http\Request;
use Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function makeResponse($response)
    {
        return [
            "success" => $response->success || true,
            "message" => $response->message || null,
            "error" => $response->error || null,
            "data" => $response->data || null,
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), ['name' => 'required', 'description' => 'required']);
        if ($valid->fails()) {
            return response()->json([
                'success' => false,
                'response' => $valid->messages()]);}
        $directory = new Directory();
        $directory->user_id = auth()->user()->id;
        $directory->name = $request->input('name');
        $directory->description = $request->input('description');
        $directory->meta = $request->input('meta');
        $directory->size = $request->input('size');
        $directory->parent_id = $request->input('parent_id');
        $directory->save();
        return response()->json([
            'success' => true,
            'data' => $directory
                ->toArray(),
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
        $directory = Directory::find($id);
        $directory->update($request->all());
        return response()->json($directory, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $directory = Directory::find($id);
        if (!$directory) {
            return response()->json('Not found', 404);
        }
        try {
            $directory->delete();
            return response()->json('data deleted', 200);

        } catch (\Throwable $th) {
            $response = ["message" => "failed to delete", "status" => 500, "error" => $th];
            return response()
                ->json($this->makeResponse($response), 500);
        }
    }
}