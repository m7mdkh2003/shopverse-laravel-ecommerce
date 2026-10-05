<?php
namespace Tests\Feature;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class StorefrontTest extends TestCase
{
    use RefreshDatabase;
    public function test_shop_can_filter_by_search_term(): void { Product::factory()->create(['name'=>'Special Watch']); Product::factory()->create(['name'=>'Basic Shirt']); $this->get('/shop?q=Special')->assertOk()->assertSee('Special Watch')->assertDontSee('Basic Shirt'); }
}
