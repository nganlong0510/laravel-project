<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        return view('comments.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CommentRequest  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, Post $post)
    {
        $post->comments()->create($request->validated());

        return redirect()->route('posts.show', $post)->with('success', 'Comment created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, Comment $comment)
    {
        return view('comments.edit', compact('post', 'comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        $post = $comment->post;

        return redirect()->route('posts.show', $post)->with('success', 'Comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $post = $comment->post;
        $comment->delete();

        return redirect()->route('posts.show', $post)->with('success', 'Comment deleted successfully.');
    }
}
