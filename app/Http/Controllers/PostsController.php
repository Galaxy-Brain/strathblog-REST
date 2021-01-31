<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
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
            'title'=>'required',
            'image'=>'required|mimes:png,jpg',
            'content'=>'required|min:30',
        ]);

        $post = new Post();

        $image = $request->file('image');
        if (isset($image)){
            $title = Str::slug($request->title);
            $date = Carbon::now()->toDateString();
            $ext = $image->getClientOriginalExtension();

            $imagename = $title.'-'.$date.'.'.$ext;

            if (!file_exists('images/posts')) {
                mkdir('images/posts', 0777, true);
            }

            $image->move('images/posts', $imagename);
        }else{
            $imagename = 'Default.jpg';
        }

        $post->title = $request->title;
        $post->image = $imagename;
        $post->content = $request->content;
        $post->save();

        return response('Succfessfully Created a new Post', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Post::find($id);
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
        $this->validate($request, [
            'title'=>'required',
            'image'=>'required|mimes:png,jpg',
            'content'=>'required|min:30',
        ]);

        $post = new Post();

        $image = $request->file('image');
        if (isset($image)){
            $title = Str::slug($request->title);
            $date = Carbon::now()->toDateString();
            $ext = $image->getClientOriginalExtension();

            $imagename = $title.'-'.$date.'.'.$ext;

            if (!file_exists('images/posts')) {
                mkdir('images/posts', 0777, true);
            }

            $image->move('images/posts', $imagename);
        }else{
            $imagename = 'Default.jpg';
        }

        $post->title = $request->title;
        $post->image = $imagename;
        $post->content = $request->content;
        $post->save();

        return response('Succfessfully Updated Your Post', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        unlink('images/post/'.$post->image);
        $post->delete();
        return response('Successfilly Deleted Your Post', 200)
    }
}
