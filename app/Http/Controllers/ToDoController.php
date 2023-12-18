<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToDoList;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ToDoList::where('completed', 0)->get();
        return view('home', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $todo_title = $request->todo;
        $check_same = ToDoList::where('title', $todo_title)->first();
        if(!is_null($check_same)) {
            return $response = [
                'status' => 0,
                'data' => 'Already Added'
            ];
        }
        $todo = new ToDoList;
        $todo->title = $todo_title;

        $todo->save();
        if(!empty($todo)) {
            $response = [
                'status' => 1,
                'data' => $todo
            ];
        }
        else{
            $response = [
                'status' => 0,
                'data' => 'Nothing Pending'
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = ToDoList::all();
        if(!is_null($data)) {
            $response = [
                'status' => 1,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 0,
                'data' => 'Nothing Pending'
            ];
        }
        
        return response()->json($response);
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
    public function complete($id)
    {
        $complete = ToDoList::where('id', $id)->first();
        $complete->completed = 1;
        $complete->save();
        $data = ToDoList::where('completed', 0)->get();
        if(!is_null($data)) {
            $response = [
                'status' => 1,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 0,
                'data' => 'Nothing Pending'
            ];
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $complete = ToDoList::find($id)->delete();
        $data = ToDoList::where('completed', 0)->get();
        if(!is_null($data)) {
            $response = [
                'status' => 1,
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 0,
                'data' => 'Nothing Pending'
            ];
        }
        return response()->json($response);
    }
}
