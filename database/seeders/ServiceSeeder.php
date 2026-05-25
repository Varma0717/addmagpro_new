<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty & Personal Care Services',
                'icon_url' => '/assets/icons/services/beauty.svg',
                'action_url' => '/services/beauty',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Wedding Planning',
                'slug' => 'wedding-planning',
                'description' => 'Wedding Planning & Coordination',
                'icon_url' => '/assets/icons/services/wedding.svg',
                'action_url' => '/services/wedding',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Gym',
                'slug' => 'gym',
                'description' => 'Fitness & Gym Memberships',
                'icon_url' => '/assets/icons/services/gym.svg',
                'action_url' => '/services/gym',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Online & Offline Courses',
                'icon_url' => '/assets/icons/services/education.svg',
                'action_url' => '/services/education',
                'display_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Packers & Movers',
                'slug' => 'packers-movers',
                'description' => 'Moving & Relocation Services',
                'icon_url' => '/assets/icons/services/packers.svg',
                'action_url' => '/services/packers',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Repairs & Services',
                'slug' => 'repairs-services',
                'description' => 'Home & Electronics Repairs',
                'icon_url' => '/assets/icons/services/repairs.svg',
                'action_url' => '/services/repairs',
                'display_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Rent & Hire',
                'slug' => 'rent-hire',
                'description' => 'Rentals & Equipment Hire',
                'icon_url' => '/assets/icons/services/rent.svg',
                'action_url' => '/services/rent',
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Jobs',
                'slug' => 'jobs',
                'description' => 'Job Listings & Recruitment',
                'icon_url' => '/assets/icons/services/jobs.svg',
                'action_url' => '/services/jobs',
                'display_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Loans',
                'slug' => 'loans',
                'description' => 'Personal & Business Loans',
                'icon_url' => '/assets/icons/services/loans.svg',
                'action_url' => '/services/loans',
                'display_order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Real Estate',
                'slug' => 'real-estate',
                'description' => 'Property & Real Estate',
                'icon_url' => '/assets/icons/services/realestate.svg',
                'action_url' => '/services/realestate',
                'display_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'PG/Hostel',
                'slug' => 'pg-hostel',
                'description' => 'PG & Hostel Accommodations',
                'icon_url' => '/assets/icons/services/pg.svg',
                'action_url' => '/services/pg',
                'display_order' => 11,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::firstOrCreate(
                ['slug' => $service['slug']],
                $service
            );
        }
    }
}
