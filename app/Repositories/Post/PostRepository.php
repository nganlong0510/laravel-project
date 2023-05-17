<?php

namespace App\Repositories\Post;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository implements PostRepositoryInterface
{
    public function getAllByUser()
    {
        return Auth::user()
            ? Auth::user()->posts->whereNull('deleted_at')
            : Post::all()->whereNull('deleted_at')->sortByDesc('created_at');
    }

    public function create(array $data)
    {
        $user = Auth::user();
        if (!$user) {
            return Post::create($data);
        }

        $post = $user->posts()->create($data);
        $post->categories()->attach($data['categories_id']);

        return $post;
    }

    public function find($id)
    {
        $user = Auth::user();
        if (!$user) {
            return Post::findOrFail($id)->whereNull('deleted_at');
        }

        return $user->posts()->whereNull('deleted_at')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $user = Auth::user();
        $post = Post::findOrFail($id)->whereNull('deleted_at');

        // If authenticated user, sync updated categories of this post.
        if ($user) {
            $post = $user->posts()->whereNull('deleted_at')->findOrFail($id);
            $post?->categories()->sync($data['categories_id']);
        }
        // Update new data.
        $post?->update($data);

        return $post;
    }

    public function delete($id)
    {
        $user = Auth::user();
        $post = $user ? $user->posts()->findOrFail($id) : Post::findOrFail($id);
        // Detach from its categories.
        $post->categories()->detach();

        // Delete comments of this post.
        $post->comments()->delete();

        $post->delete();
    }
}
