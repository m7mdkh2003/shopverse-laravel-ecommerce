<?php
namespace Database\Factories;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array { $subtotal=fake()->randomFloat(2,30,600); $shipping=$subtotal>=200?0:12; return ['user_id'=>User::factory(),'order_number'=>'ORD-'.fake()->unique()->numerify('########'),'status'=>'pending','subtotal'=>$subtotal,'shipping_amount'=>$shipping,'total'=>$subtotal+$shipping,'customer_name'=>fake()->name(),'email'=>fake()->safeEmail(),'phone'=>fake()->phoneNumber(),'address'=>fake()->streetAddress(),'city'=>fake()->city(),'country'=>'Palestine','payment_method'=>'cash_on_delivery']; }
}
