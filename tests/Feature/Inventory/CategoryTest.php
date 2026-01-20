<?php

namespace Tests\Feature\Inventory;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_can_be_created()
    {
        $response = $this->postJson('/api/inventory/categories', [
            'name' => 'Gift Box',
            'slug' => 'gift-box',
            'filter_tag' => 'box',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('categories', [
            'slug' => 'gift-box',
            'deleted_at' => null,
        ]);
    }

    /** @test */
    public function duplicate_slug_is_not_allowed()
    {
        Category::create([
            'name' => 'Box',
            'slug' => 'box',
        ]);

        $response = $this->postJson('/api/inventory/categories', [
            'name' => 'Another Box',
            'slug' => 'box',
        ]);

        $response->assertStatus(422);
    }

    /** @test */
public function categories_can_be_listed()
{
 Category::create([
  'name' => 'A',
  'slug' => 'a'
]);

Category::create([
  'name' => 'B',
  'slug' => 'b'
]);

Category::create([
  'name' => 'C',
  'slug' => 'c'
]);

    $response = $this->getJson('/api/inventory/categories');

    $response->assertStatus(200)
             ->assertJsonCount(3);
}
    /** @test */
    public function category_can_be_updated()
    {
        $category = Category::create([
            'name' => 'Old Name',
            'slug' => 'old-name',
        ]);

        $response = $this->putJson("/api/inventory/categories/{$category->id}", [
            'name' => 'New Name',
            'slug' => 'new-name',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'slug' => 'new-name',
        ]);
    }

    /** @test */
    public function category_can_be_soft_deleted()
    {
        $category = Category::create([
            'name' => 'Delete Me',
            'slug' => 'delete-me',
        ]);

        $response = $this->deleteJson("/api/inventory/categories/{$category->id}");

        $response->assertStatus(200);

        $this->assertSoftDeleted('categories', [
            'id' => $category->id,
        ]);
    }

    /** @test */
    public function category_with_products_cannot_be_deleted()
    {
        $category = Category::create([
            'name' => 'Protected',
            'slug' => 'protected',
        ]);

        Product::create([
            'name' => 'Sample Product',
            'category_id' => $category->id,
        ]);

        $response = $this->deleteJson("/api/inventory/categories/{$category->id}");

        $response->assertStatus(422);
    }

    /** @test */
    public function soft_deleted_category_can_be_restored()
    {
        $category = Category::create([
            'name' => 'Restore Me',
            'slug' => 'restore-me',
        ]);

        $category->delete();

        $response = $this->postJson("/api/inventory/categories/{$category->id}/restore");

        $response->assertStatus(200);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'deleted_at' => null,
        ]);
    }
}
