<?php
namespace Tests\Feature;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\CheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class OrderStateTest extends TestCase
{
    use RefreshDatabase;
    public function test_cancelling_order_restores_stock(): void { $user=User::factory()->create(); $product=Product::factory()->create(['stock'=>5,'price'=>20]); $user->cartItems()->create(['product_id'=>$product->id,'quantity'=>2]); $order=app(CheckoutService::class)->checkout($user,['customer_name'=>'Salam','email'=>'sal@example.com','phone'=>'059','address'=>'Street','city'=>'Nablus','country'=>'Palestine']); $this->assertSame(3,$product->fresh()->stock); app(CheckoutService::class)->cancel($order); $this->assertSame(5,$product->fresh()->stock); $this->assertSame('cancelled',$order->fresh()->status); }
    public function test_completed_and_cancelled_orders_are_terminal(): void { $order=new Order(['status'=>'completed']); $this->assertFalse($order->canTransitionTo('cancelled')); $order->status='cancelled'; $this->assertFalse($order->canTransitionTo('processing')); }
}
