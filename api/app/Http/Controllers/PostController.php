<?php

namespace App\Http\Controllers;

use App\Post;
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
        //
    }

    public function index()
    {
        $posts = Post::All();
        return response()->json($posts, 200);
    }

    public function create(Request $request)
    {
        $post = new Post;

        $post->title = $request->title;
        $post->body = $request->body;
        $post->description = $request->description;

        $post->save();

        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post, 200);
    }

    public function update(Request $Request, $id)
    {
        $post = Post::find($id);

        $post->title = $request->title;
        $post->body = $request->body;
        $post->description = $request->description;

        $post->save();

        return response()->json($post, '204');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json('post removed.', 204);
    }
}
