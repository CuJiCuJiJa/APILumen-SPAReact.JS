<?php

namespace App\Http\Middleware;

use Closure;
use App\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $post = [];
        $cant = Post::all()->count();

        if ($cant == 0) {
            
            return response()->json(array(        
                'error' => true,
                'status_code' => 400,
                'response' => 'resource_not_found'));
        }

        if ($request->route()[2]) {

            try
            {                                        
                $id = $request->route()[2]['id'];
                $post = Post::findOrFail($id);      
            }                                       
            catch(ModelNotFoundException $e)
            {
                return Response::json(array(        
                    'error' => true,
                    'status_code' => 400,
                    'response' => 'resource_not_found'));
            }   
        }
        return $next($request, $post);
    }
}
