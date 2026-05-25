<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Main categories from mockup
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, Footwear & Accessories',
                'image_url' => '/assets/icons/categories/fashion.jpg',
                'parent_id' => null,
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty Products & Cosmetics',
                'image_url' => '/assets/icons/categories/beauty.jpg',
                'parent_id' => null,
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Footwear',
                'slug' => 'footwear',
                'description' => 'Shoes, Boots & Sandals',
                'image_url' => '/assets/icons/categories/footwear.jpg',
                'parent_id' => null,
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Home Decor & Furnishings',
                'image_url' => '/assets/icons/categories/homeliving.jpg',
                'parent_id' => null,
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Bags, Watches & Jewelry',
                'image_url' => '/assets/icons/categories/accessories.jpg',
                'parent_id' => null,
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Mobile Phones, Laptops & Gadgets',
                'image_url' => '/assets/icons/categories/electronics.jpg',
                'parent_id' => null,
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports Equipment & Activewear',
                'image_url' => '/assets/icons/categories/sports.jpg',
                'parent_id' => null,
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books & E-books',
                'image_url' => '/assets/icons/categories/books.jpg',
                'parent_id' => null,
                'display_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
