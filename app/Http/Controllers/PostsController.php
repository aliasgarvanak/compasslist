<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =  Post::orderBy('created_at','DESC')->get();
        return response()->json([
            'class' => 'success',
            'posts'=> $posts,
            'success'=> true
        ]);
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
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'description'   => 'required',
        ]);
        if ($validator->fails()) {
           return response()->json([
                'class' => 'error',
                'message'=> 'Invalid Data',
                'success'=> false
            ]);
        }
        else{
            $post = new Post;
            $post->name = $request->name;
            $post->description = $request->description;
            $post->save();

            return response()->json([
                'class' => 'success',
                'message'=> 'Post Added',
                'success'=> true
            ]);
        }

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
        $existingPost = Post::find($id);
        
        if($existingPost)
        {
                return response()->json([
                    'class' => 'success',
                    'message'=> 'Post Found',
                    'post'  => $existingPost,
                    'success'=> true
                ]);
        }
        else{
            return response()->json([
                'class' => 'error',
                'message'=> 'No Post found',
                'success'=> false
            ]);
            
           
        }
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
        $existingPost = Post::find($id);
        if($existingPost)
        {
            $validator = Validator::make($request->all(), [
                'name'          => 'required',
                'description'   => 'required',
            ]);
            if ($validator->fails()) {
               return response()->json([
                    'class' => 'error',
                    'message'=> 'Invalid Data',
                    'success'=> false
                ]);
            }
            else{
                $existingPost->name = $request->name;
                $existingPost->description = $request->description;
                $existingPost->updated_at = Carbon::now();
                $existingPost->save();

                return response()->json([
                    'class' => 'success',
                    'message'=> 'Post Updated',
                    'post'  => $existingPost,
                    'success'=> true
                ]);
            }
        }
        else{
            return response()->json([
                'class' => 'error',
                'message'=> 'No Post found',
                'success'=> false
            ]);
            
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingPost = Post::find($id);
        
        if($existingPost)
        {
                $existingPost->delete();
                return response()->json([
                    'class' => 'success',
                    'message'=> 'Post Deleted',
                    'posts'  => Post::orderBy('created_at','DESC')->get(),
                    'success'=> true
                ]);
        }
        else{
            return response()->json([
                'class' => 'error',
                'message'=> 'No Post found',
                'success'=> false
            ]);
            
           
        }
    }
}
