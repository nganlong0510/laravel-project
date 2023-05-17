<?php

namespace App\Http\Requests\API;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Only authorise user can request to edit or delete.
        if ($this->route()->getName() === 'posts.edit' || $this->route()->getName() === 'posts.destroy') {
            $post = Post::find($this->route('id'));

            // Check if the authenticated user is the owner of the post
            return $post instanceof Post && $this->user()->id === $post->user_id;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:10',
            'categories_id' => 'required|array',
        ];
    }
}
