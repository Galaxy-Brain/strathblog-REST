<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->id;
        $comment->comment = $request->comment;
        $comment->save();
        $comment->user;

        return response()->json([
            'success' => true,
            'comment'=>$comment,
            'message' => 'comment added'
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($request->id);
        //check if user is editing his own comment
        if($comment->id != auth()->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorize access'
            ]);
        }
        $comment->comment = $request->comment;
        $comment->update();

        return response()->json([
            'success' => true,
            'message' => 'comment edited'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        //check if user is editing his own comment
        if($comment->user_id != auth()->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'unauthorize access'
            ]);
        }
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted'
        ]);
    }
}
