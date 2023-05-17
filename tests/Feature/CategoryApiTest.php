<?php

namespace Tests\Feature;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint.
     *
     * @return void
     */
    public function testIndex()
    {
        // Create a user and categories using the factory seeder
        $user = User::factory()->create();
        Category::factory()->count(5)->create(['user_id' => $user->id]);

        // Send a GET request to the index endpoint
        Sanctum::actingAs($user);
        $response = $this->json('GET', '/api/categories');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    /**
     * Test create endpoint.
     *
     * @return void
     */
    public function testCreate()
    {
        // Create a user using the factory seeder
        $user = User::factory()->create();
        $input = [
            'title' => 'Test category',
            'description' => 'This is a test category',
            'user_id' => $user->id,
        ];
        // Send a category request to the create endpoint
        Sanctum::actingAs($user);
        $response = $this->json('category', '/api/categories', $input);

        // Assert the response
        $response->assertStatus(201);
        $jsonResponse = $response->json();

        // Get the created category from the response JSON
        $category = Category::findOrFail($response->json('data.id'));
        $resource = new CategoryResource($category);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the category attributes using the CategoryResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test update endpoint.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Create a user and a category using the factory seeder
        $user = User::factory()->create();
        $categoryFactory = Category::factory()->create(['user_id' => $user->id]);

        // Send a PUT request to the update endpoint
        Sanctum::actingAs($user);
        $response = $this->json('PUT', '/api/categories/' . $categoryFactory->id, [
            'title' => 'Updated Test category',
            'description' => 'This is an updated test category',
        ]);

        // Assert the response
        $response->assertStatus(200);
        $jsonResponse = $response->json();

        // Get the created category from the response JSON
        $category = Category::findOrFail($response->json('data.id'));
        $resource = new CategoryResource($category);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the category attributes using the CategoryResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test show endpoint.
     *
     * @return void
     */
    public function testShow()
    {
        // Create a user and a category using the factory seeder
        $user = User::factory()->create();
        $categoryFactory = Category::factory()->create(['user_id' => $user->id]);

        // Send a GET request to the show endpoint
        Sanctum::actingAs($user);
        $response = $this->json('GET', '/api/categories/' . $categoryFactory->id);

        // Assert the response
        $response->assertStatus(200);
        $jsonResponse = $response->json();

        // Get the created category from the response JSON
        $category = Category::findOrFail($response->json('data.id'));
        $resource = new CategoryResource($category);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the category attributes using the CategoryResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test delete endpoint.
     *
     * @return void
     */
    public function testDelete()
    {
        // Create a user and a category using the factory seeder.
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        // Send a DELETE request to the delete endpoint
        Sanctum::actingAs($user);
        $response = $this->json('DELETE', '/api/categories/' . $category->id);

        // Assert the response
        $response->assertStatus(200);

        // Assert the category has been deleted
        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);

        $this->assertDatabaseMissing('categories_posts', [
            'categories_id' => $category->id,
        ]);
    }

    /**
     * Test getPosts endpoint.
     *
     * @return void
     */
    public function testGetPosts()
    {
        $user = User::factory()->create();
        $categoryFactory = Category::factory()->create(['user_id' => $user->id]);
        Post::factory()->count(5)->create(['user_id' => $user->id]);

        // Send a DELETE request to the delete endpoint
        Sanctum::actingAs($user);
        $response = $this->json('GET', '/api/categories/' . $categoryFactory->id . '/posts');

        // Assert the response
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }
}
