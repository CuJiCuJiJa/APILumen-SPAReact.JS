<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;    

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('PostExist', ['only' => [
            'update',
            'destroy',
            'show',
            'index'
        ]]);
    }

    protected function validator(array $data){
        
        return Validator::make($data, [
            'title' => 'required|string',
            'body' => 'required|string'
        ]);
    }

    public function index()
    {
        $post = Post::all();
        return response()->json($post , 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();    //PARSE JSON TO ARRAY
        
        $validator = $this->validator($data);   //VALIDATE INPUT
        
        if ($validator->passes()) {             //IF VALIDATION PASSES
            $post = new Post;                   //SAVE
            $post->title = $data['title'];
            $post->body = $data['body'];
            $post->user_id = Auth::user()->id;  //ID OF AUTH USER
            $post->save();

            return response()->json($post, 201);//RETURNS OK
        
        }else{

            return response()->json($validator->errors(), 400); //RETURN VALIDATION ERRORS
        }

    }

    public function update(Request $request, $id) 
    {
        $post = Post::find($id);

        $data = $request->all();                                //PARSE JSON INPUT TO ARRAY
        $validator = $this->validator($data);                   //VALIDATE INPUT

        if ($validator->passes()) {                             //IF VALIDATION PASSES
            
            $post->title = $data['title'];        
            $post->body = $data['body'];

            $post->save();                                      //SAVE DATA

            return response()->json($post, 200);                //RETURN OK
        }else{                                                  //IF NOT

            return response()->json($validator->errors(), 400); //RETURN VALIDATION ERRORS
        }   
    }

    public function destroy($id)              
    {   
        $post = Post::find($id);
        $post->delete();                        //DELETE POST
        return response()->json(200);           //RETURN OK
    }

    public function show($id)                 
    {                                           //IF POST DOES NOT EXIST THE EXCEPTION IT'S 
        $post = Post::find($id);
        return response()->json($post, 200);    //CATCHED BY THE MIDDLEWARE //RETURN OK
    }

}
