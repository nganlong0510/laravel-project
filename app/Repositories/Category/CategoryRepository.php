<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllByUser(User $user)
    {
        return $user->categories()->whereNull('deleted_at')->get();
    }

    public function create(array $data)
    {
        return Auth::user()?->categories()->create($data);
    }

    public function find($id)
    {
        return Auth::user()?->categories()->whereNull('deleted_at')->findOrFail($id);
    }

    public function update($id, array $data)
    {
        $category =  Auth::user()?->categories()->whereNull('deleted_at')->findOrFail($id);
        $category->update($data);

        return $category;
    }

    public function delete($id)
    {
        $category = Auth::user()->categories()->findOrFail($id);
        // Detach from its posts.
        $category->posts()->detach();

        $category->delete();
    }

    public function getPosts($id)
    {
        $category = Auth::user()->categories()->findOrFail($id);

        return $category->posts()->whereNull('deleted_at')->get();
    }
}
