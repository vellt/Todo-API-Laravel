<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function store(Request $request){
        // we validate the data
        $data =$request->validate([
            'title'=>'required|string|max:255',
            'priority'=>'nullable|integer|min:1|max:3',
            'done'=>'boolean',
            ]);

        // we created todo and saved in the database
        $todo=Todo::create($data);

        // return json, NOT view
        return response()->json([
            'status'=>true,
            'message'=>'todo created.',
            'data'=>$todo,
            ], 201); // add status
    }

    public function index(Request $request){

        $todos=Todo::all();

        return response()->json([
            'status'=>true,
            'message'=>'Todos retrieved',
            'data'=>$todos,
            ]);
    }

    public function show(Request $request, $id){

        $todos=Todo::find($id);

        return response()->json([
            'status'=>true,
            'message'=>'Todo found.',
            'data'=>$todos,
            ]);
    }

    public function update(Request $request, $id){
        // we validate the data
        $data =$request->validate([
            'title'=>'nullable|string|max:255', //nullable because this is an update method
            'priority'=>'nullable|integer|min:1|max:3',
            'done'=>'boolean',
            ]);

        $todo=Todo::find($id);

        if($todo){
            $todo->update($data);
            return response()->json([
            'status'=>true,
            'message'=>'Todo found.',
            'data'=>$todo,
            ]); //default status code is 200
        }else{
            return response()->json([
            'status'=>false,
            'message'=>'Todo not found.',
            'data'=>$todo, //or null
            ],404);
        }


    }

    public function delete(Request $request, $id){

        $todo=Todo::find($id);

        if($todo){
            $todo->delete();
            return response()->json([
            'status'=>true,
            'message'=>'Todo deleted.',
            'data'=>null,
            ]); //default status code is 200
        }else{
            return response()->json([
            'status'=>false,
            'message'=>'Todo not found.',
            'data'=>$todo, //or null
            ],404);
        }


    }
}
