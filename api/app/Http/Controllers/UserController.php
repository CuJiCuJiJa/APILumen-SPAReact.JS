<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $users = User::All();
        return response()->json($users, 200);
    }

    public function create(Request $request)
    {
        $user = new User;
        $data = $request->json()->all();
        $user->name = $data->name;
        $user->password = Hash::make($data->password);
        $user->email = $data->email;
        $user->api_token = str_random(60);

        $user->save();

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function update(Request $Request, $id)
    {
        $user = User::find($id);

        $data = $request->json()->all();

        $user->name = $data->name;
        $user->password = Hash::make($data->password);
        $user->email = $data->email;

        $user->save();

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json('user removed.', '200');
    }

    public function getToken(Request $request)
    {
        $data = $request->json()->all();
        $user = User::where('name', data['name'])->first();

        //TODO:check if attempt works
        if ($user && Hash::check($data['password'], $user->password)) 
        {
            
            return response()->json($user, 200);
        }
        else
        {
            return response()->json(['error' => 'No content'], 406);
        }
    }
}
