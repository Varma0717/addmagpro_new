<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Festive Vibes - Perfect Ethnic Styles',
                'description' => 'Explore our exclusive collection of ethnic wear for the festive season',
                'image_url' => '/assets/banners/festive-vibes.jpg',
                'action_url' => '/category/ethnic-wear',
                'banner_type' => 'promo',
                'display_location' => 'home_slider',
                'display_order' => 1,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Up to 80% Sale',
                'description' => 'Massive discounts on selected items. Limited time offer!',
                'image_url' => '/assets/banners/sale-80.jpg',
                'action_url' => '/sale',
                'banner_type' => 'campaign',
                'display_location' => 'home_slider',
                'display_order' => 2,
                'is_active' => true,
                'start_date' => now(),
                'end_date' => now()->addDays(15),
            ],
            [
                'title' => 'New Launches',
                'description' => 'Check out the latest products launched this week',
                'image_url' => '/assets/banners/new-launches.jpg',
                'action_url' => '/new-launches',
                'banner_type' => 'category',
                'display_location' => 'home_featured',
                'display_order' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::firstOrCreate(
                ['title' => $banner['title']],
                $banner
            );
        }
    }
}
