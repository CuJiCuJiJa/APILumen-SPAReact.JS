<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Validator;
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
        $data = json_decode($request, true);    //PARSE JSON TO ARRAY
        
        $validator = $this->validator($data);   //VALIDATE INPUT
        
        if ($validator->passes()) {             //IF VALIDATION PASSES

            $post = new Post;                   //SAVE
            $post->title = $data->title;
            $post->body = $data->body;
            $post->user_id = auth('api')->user()->id; //yo creo que funciona
            $post->save();

            return response()->json($post, 201);//RETURNS OK
        
        }else{

            return response()->json($validator->errors(), 400); //RETURN VALIDATION ERRORS
        }

    }

    public function update(Request $request, $post) //POST COMES FROM POSTEXIST MIDDLEWARE
    {
        $data = json_decode($request, true);    //PARSE JSON INPUT TO ARRAY
        
        $validator = $this->validator($data);   //VALIDATE INPUT

        if ($validator->passes()) {             //IF VALIDATION PASSES
            
            $post->title = $data->title;        
            $post->body = $data->body;

            $post->save();                      //SAVE DATA

            return response()->json($post, 200);//RETURN OK
        }else{                                  //IF NOT

            return response()->json($validator->errors(), 400); //RETURN VALIDATION ERRORS
        }   
    }

    public function destroy($post)              //POST COMES FROM POSTEXIST MIDDLEWARE
    {   
        $post->delete();                        //DELETE POST

        return response()->json(200);           //RETURN OK
    }

    public function show($post)                 //$POST COMES FROM THE POSTEXIST MIDDLEWARE
    {                                           //IF POST DOES NOT EXIST THE EXCEPTION IT'S 
        return response()->json($post, 200);    //CATCHED BY THE MIDDLEWARE //RETURN OK
                                                
    }

}
