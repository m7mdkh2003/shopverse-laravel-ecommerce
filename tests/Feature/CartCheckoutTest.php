<?php
namespace Tests\Feature;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class CartCheckoutTest extends TestCase
{
    use RefreshDatabase;
    public function test_customer_can_add_product_to_cart(): void { $user=User::factory()->create(); $product=Product::factory()->create(['stock'=>10]); $this->actingAs($user)->post(route('cart.store',$product),['quantity'=>2])->assertRedirect(); $this->assertDatabaseHas('cart_items',['user_id'=>$user->id,'product_id'=>$product->id,'quantity'=>2]); }
    public function test_checkout_creates_order_items_and_reduces_stock(): void { $user=User::factory()->create(); $product=Product::factory()->create(['stock'=>10,'price'=>50]); $user->cartItems()->create(['product_id'=>$product->id,'quantity'=>2]); $this->actingAs($user)->post(route('checkout.store'),['customer_name'=>'Salam','email'=>'sal@example.com','phone'=>'0590000000','address'=>'Main Street','city'=>'Nablus','country'=>'Palestine'])->assertRedirect(); $this->assertDatabaseCount('orders',1); $this->assertDatabaseHas('order_items',['product_id'=>$product->id,'quantity'=>2,'line_total'=>100]); $this->assertSame(8,$product->fresh()->stock); $this->assertDatabaseCount('cart_items',0); }
    public function test_checkout_rejects_insufficient_stock(): void { $user=User::factory()->create(); $product=Product::factory()->create(['stock'=>1]); $user->cartItems()->create(['product_id'=>$product->id,'quantity'=>2]); $this->actingAs($user)->post(route('checkout.store'),['customer_name'=>'Salam','email'=>'sal@example.com','phone'=>'0590000000','address'=>'Main Street','city'=>'Nablus','country'=>'Palestine'])->assertSessionHasErrors('cart'); $this->assertDatabaseCount('orders',0); }
}
