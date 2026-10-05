<?php
namespace Database\Factories;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array { $name=fake()->words(3,true); return ['category_id'=>Category::factory(),'name'=>$name,'slug'=>Str::slug($name).'-'.fake()->unique()->numberBetween(1000,9999),'description'=>fake()->paragraph(),'price'=>fake()->randomFloat(2,10,500),'compare_at_price'=>null,'stock'=>fake()->numberBetween(5,100),'image'=>'storefront/img/products/product1/1.png','is_featured'=>false,'is_active'=>true]; }
}
