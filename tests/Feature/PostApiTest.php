<?php

namespace Tests\Feature;

use App\Http\Resources\Post\PostResource;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Laravel\Sanctum\Sanctum;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test index endpoint.
     *
     * @return void
     */
    public function testIndex()
    {
        // Create a user and posts using the factory seeder
        $user = User::factory()->create();
        // Create some categories first.
        Category::factory()->count(5)->create(['user_id' => $user->id]);
        // In factory, assign categories to posts.
        Post::factory()->count(5)->create(['user_id' => $user->id]);

        // Send a GET request to the index endpoint
        Sanctum::actingAs($user);
        $response = $this->json('GET', '/api/posts');

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
        Category::factory()->count(5)->create(['user_id' => $user->id]);
        $input = [
            'title' => 'Test Post',
            'description' => 'This is a test post',
            'user_id' => $user->id,
            'categories_id' => Category::all()->random(2)->pluck('id')->toArray(),
        ];

        // Send a POST request to the create endpoint
        Sanctum::actingAs($user);
        $response = $this->json('POST', '/api/posts', $input);

        // Assert the response
        $response->assertStatus(201);
        $jsonResponse = $response->json();

        // Get the created post from the response JSON
        $post = Post::findOrFail($response->json('data.id'));
        $resource = new PostResource($post);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the post attributes using the PostResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test update endpoint.
     *
     * @return void
     */
    public function testUpdate()
    {
        // Create a user and a post using the factory seeder
        $user = User::factory()->create();
        // Create a list of catories.
        Category::factory()->count(5)->create(['user_id' => $user->id]);

        // Create a post.
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Make a PUT request.
        Sanctum::actingAs($user);
        $response = $this->json('PUT', '/api/posts/' . $post->id, [
            'title' => 'Updated Test Post',
            'description' => 'This is an updated test post',
        ]);

        // Assert the response
        // Fail to update, require categories_id.
        $response->assertStatus(422);

        // Make another request.
        $response_2 = $this->json('PUT', '/api/posts/' . $post->id, [
            'title' => 'Updated Test Post',
            'description' => 'This is an updated test post',
            'categories_id' => $post->categories()->pluck('categories_id')->toArray(),
        ]);

        // This request should be successfully updated.
        $response_2->assertStatus(200);
        $jsonResponse = $response_2->json();

        // Get the created post from the response JSON
        $post = Post::findOrFail($response_2->json('data.id'));
        $resource = new PostResource($post);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the post attributes using the PostResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test show endpoint.
     *
     * @return void
     */
    public function testShow()
    {
        // Create a user and a post using the factory seeder
        $user = User::factory()->create();
        // Create a list of catories.
        Category::factory()->count(5)->create(['user_id' => $user->id]);

        $post = Post::factory()->create(['user_id' => $user->id]);

        // Send a GET request to the show endpoint
        Sanctum::actingAs($user);
        $response = $this->json('GET', '/api/posts/' . $post->id);

        // Assert the response
        $response->assertStatus(200);
        $jsonResponse = $response->json();

        // Get the created post from the response JSON
        $post = Post::findOrFail($response->json('data.id'));
        $resource = new PostResource($post);
        $resourceResponse = $resource->response()->getData(true);

        // Assert the post attributes using the PostResource JSON representation
        $this->assertEquals($jsonResponse, $resourceResponse);
    }

    /**
     * Test delete endpoint.
     *
     * @return void
     */
    public function testDelete()
    {
        // Create a user and a post using the factory seeder
        $user = User::factory()->create();
        // Create a list of catories.
        Category::factory()->count(5)->create(['user_id' => $user->id]);
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Send a DELETE request to the delete endpoint
        Sanctum::actingAs($user);
        $response = $this->json('DELETE', '/api/posts/' . $post->id);

        // Assert the response
        $response->assertStatus(204);

        // Assert the post has been deleted
        $this->assertSoftDeleted('posts', [
            'id' => $post->id,
        ]);
        $this->assertDatabaseMissing('categories_posts', [
            'posts_id' => $post->id,
        ]);
    }
}
