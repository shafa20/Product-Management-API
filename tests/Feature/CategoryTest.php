<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase; // This will refresh the database for each test

    /** @test */
    public function it_can_create_a_category()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Electronics',
            'description' => 'Devices and gadgets'
        ]);

        $response->assertStatus(201); // Check if created successfully
        $this->assertDatabaseHas('categories', [
            'name' => 'Electronics'
        ]);
    }

    /** @test */
    public function it_can_list_categories()
    {
        Category::factory()->create([
            'name' => 'Electronics',
        ]);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200); // Status OK
        $response->assertJsonCount(1); // One category in the list
        $response->assertJsonFragment(['name' => 'Electronics']);
    }

    /** @test */
    public function it_can_update_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->putJson("/api/categories/{$category->id}", [
            'name' => 'Updated Electronics',
            'description' => 'Updated description'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated Electronics']);
    }

    /** @test */
    // public function it_can_delete_a_category()
    // {
    //     $category = Category::factory()->create();

    //     $response = $this->deleteJson("/api/categories/{$category->id}");

    //     $response->assertStatus(200);
    //     $response->assertJson(['message' => 'Category deleted successfully']);

    //     //$response->assertJson(['message' => 'Category deleted']);
    //     $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    // }
    public function it_can_delete_a_category()
{
    // Create a category
    $category = Category::factory()->create();

    // Send the delete request
    $response = $this->deleteJson("/api/categories/{$category->id}");

    // Assert that the response status is 200 (OK)
    $response->assertStatus(200);

    // Assert that the response JSON contains the correct success message
    $response->assertJson(['message' => 'Category deleted successfully']);

    // Assert that the category is removed from the database
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
}

}
