<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PostRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(): PostCollection
    {
        // Retrieve all posts
        $posts = $this->postRepository->getAllByUser();
        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest  $request
     * @return PostResource
     */
    public function store(PostRequest $request): PostResource
    {
        // Create a new post.
        $post = $this->postRepository->create($request->validated());
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return PostResource
     */
    public function show(int $id): PostResource
    {
        // Retrieve a specific post.
        try {
            $post = $this->postRepository->find($id);
            return new PostResource($post);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Post not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest  $request
     * @param  int  $id
     * @return PostResource
     */
    public function update(PostRequest $request, $id)
    {
        // Update the post.
        try {
            $post = $this->postRepository->update($id, $request->validated());
            return new PostResource($post);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Post not found.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        // Delete the post
        $this->postRepository->delete($id);

        return response()->json(null, 204);
    }
}
