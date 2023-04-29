<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments =  Comment::with('user','company')->where('status',1)->latest()->get();
        return  new CommentCollection($comments);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'content'=>$request->content,
            'review_id'=>$request->review_id,
            'status'=>1,
            'user_id'=>JWTAuth::user()->id,  
           
        ]);
        return response()->json(['message'=>'comment created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        $comment =  Comment::with('company','user')->where('id',$comment->id,'status',1)->get();
        return  new CommentCollection($comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->content = $request->content;
        $comment->update();
        return new CommentResource($comment); 
    }

    // change status of comment from active to hidden or visversa
    public function changeStatus(Comment $comment){
        if($comment->status==0)$comment->status=1; else $comment->status=0;
        $comment->update();
        return new CommentResource($comment); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::find($comment->id)->where('user_id',1);
        $comment->delete();
        return  response()->json(['success'=>'comment deleted successufuly']);
    }
    public function  deleteComment($id){
        $comment = Comment::where('id',$id)->where('user_id',JWTAuth::user()->id)->first();
        if($comment){
            $comment->update(['status'=>0]);
            return  response()->json(['message'=>'Comment deleted successufuly']);
        }
        else{
            return  response()->json(['message'=>'not found'],404);
        }
    }
}
