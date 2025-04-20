<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase; // This will refresh the database for each test

    /** @test */
    public function it_can_create_a_product()
    {
        $category = Category::factory()->create();

        $response = $this->postJson('/api/products', [
            'name' => 'iPhone 15',
            'description' => 'Apple smartphone',
            'price' => 999.99,
            'category_id' => $category->id
        ]);

        $response->assertStatus(201); // Check if created successfully
        $this->assertDatabaseHas('products', [
            'name' => 'iPhone 15',
            'price' => 999.99
        ]);
    }

    /** @test */
    public function it_can_list_products()
    {
        $category = Category::factory()->create();
        Product::factory()->create([
            'name' => 'iPhone 15',
            'category_id' => $category->id
        ]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200); // Status OK
        $response->assertJsonCount(1); // One product in the list
        $response->assertJsonFragment(['name' => 'iPhone 15']);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated iPhone',
            'description' => 'Updated description',
            'price' => 899.99,
            'category_id' => $category->id
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Updated iPhone']);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Product deleted']);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}

