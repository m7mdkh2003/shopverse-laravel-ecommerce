<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'ShopVerse Admin', 'password' => 'Admin12345', 'role' => User::ROLE_ADMIN,
        ]);
        User::updateOrCreate(['email' => 'customer@example.com'], [
            'name' => 'Demo Customer', 'password' => 'Customer12345', 'role' => User::ROLE_USER,
        ]);

        $categories = collect([
            ['name' => 'Watches', 'slug' => 'watches', 'description' => 'Modern watches and timeless accessories.'],
            ['name' => 'Clothing', 'slug' => 'clothing', 'description' => 'Everyday fashion and premium basics.'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'description' => 'Finishing touches for every outfit.'],
        ])->mapWithKeys(function ($data) {
            $category = Category::updateOrCreate(['slug' => $data['slug']], $data);
            return [$data['slug'] => $category];
        });

        $products = [
            ['category' => 'watches', 'name' => 'Analogue Resin Strap', 'slug' => 'analogue-resin-strap', 'price' => 108, 'compare_at_price' => 160, 'stock' => 18, 'featured' => true, 'folder' => 'product1'],
            ['category' => 'clothing', 'name' => 'Ridley High Waist', 'slug' => 'ridley-high-waist', 'price' => 208, 'compare_at_price' => 265, 'stock' => 12, 'featured' => true, 'folder' => 'product2'],
            ['category' => 'accessories', 'name' => 'Blush Beanie', 'slug' => 'blush-beanie', 'price' => 67, 'compare_at_price' => 105, 'stock' => 24, 'featured' => true, 'folder' => 'product3'],
            ['category' => 'clothing', 'name' => 'Mercury Tee', 'slug' => 'mercury-tee', 'price' => 48, 'compare_at_price' => 55, 'stock' => 35, 'featured' => false, 'folder' => 'product4'],
            ['category' => 'watches', 'name' => 'La Bohème Rose Gold', 'slug' => 'la-boheme-rose-gold', 'price' => 48, 'compare_at_price' => 78, 'stock' => 8, 'featured' => true, 'folder' => 'product5'],
        ];

        foreach ($products as $item) {
            Product::withTrashed()->updateOrCreate(['slug' => $item['slug']], [
                'category_id' => $categories[$item['category']]->id,
                'name' => $item['name'],
                'description' => 'A portfolio-ready catalog product migrated from the original static e-commerce front end into Laravel.',
                'price' => $item['price'],
                'compare_at_price' => $item['compare_at_price'],
                'stock' => $item['stock'],
                'image' => "storefront/img/products/{$item['folder']}/1.png",
                'gallery' => [
                    "storefront/img/products/{$item['folder']}/1.png",
                    "storefront/img/products/{$item['folder']}/2.png",
                    "storefront/img/products/{$item['folder']}/3.png",
                ],
                'is_featured' => $item['featured'],
                'is_active' => true,
                'deleted_at' => null,
            ]);
        }
    }
}
