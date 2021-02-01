<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id','desc')->get();
        foreach($posts as $post){
            //get user of post
            $post->user;
            //comments count
            $post['commentsCount'] = count($post->comments);
            //likes count
            $post['likesCount'] = count($post->likes);
            //check if users liked his own post
            $post['selfLike'] = false;
            foreach($post->likes as $like){
                if($like->user_id == auth()->user()->id){
                    $post['selfLike'] = true;
                }
            }

        }

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
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
            'photo'=>'mimes:png,jpg|nullable',
            'desc'=>'required|min:30',
        ]);

        $post = new Post();

        $image = $request->file('photo');
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

        $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->photo = $imagename;
        $post->desc = $request->desc;
        $post->save();

        return response('Successfully Created a new Post', 200);
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
            'photo'=>'mimes:png,jpg|nullable',
            'desc'=>'required|min:30',
        ]);

        $post = new Post();

        $image = $request->file('photo');
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

        $post->user_id = auth()->user()->id;
        $post->title = $request->title;
        $post->photo = $imagename;
        $post->desc = $request->desc;
        $post->save();

        return response('Successfully Updated Your Post', 200);
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
        return response('Successfully Deleted Your Post', 200);
    }


    /**
     * My Own Posts.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myPosts(){
        $posts = Post::where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'posts' => $posts,
            'user' => $user
        ]);
    }
}
