<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CategoryRequest;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Post\PostCollection;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get categories created by current user.
        return new CategoryCollection($this->categoryRepo->getAllByUser(Auth::user()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // User create new category.
        return new CategoryResource($this->categoryRepo->create($request->validated()));
    }

    /**
     * Display details of specific category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // Retrieve a specific category.
        try {
            $category = $this->categoryRepo->find($id);
            return new CategoryResource($category);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // User wants to update a category.
        if (!$this->authorize('update', $category)) {
            return response()->json(['message' => 'Not authorised to update'], 403);
        }

        // Update Category.
        try {
            $updated_category = $this->categoryRepo->update($category->id, $request->validated());
            return new CategoryResource($updated_category);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!$this->authorize('delete', $category)) {
            return response()->json(['message' => 'Not authorised to delete'], 403);
        }

        $this->categoryRepo->delete($category->id);
        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    /**
     * Get all Posts belong to the category given.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPosts(int $id)
    {
        try {
            $posts = $this->categoryRepo->getPosts($id);
            return new PostCollection($posts);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Category not found.'], 404);
        }
    }
}
