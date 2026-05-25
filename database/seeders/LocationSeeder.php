<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            // Telangana
            ['city' => 'Hyderabad', 'state' => 'Telangana', 'country' => 'India', 'latitude' => 17.3850, 'longitude' => 78.4867, 'timezone' => 'Asia/Kolkata'],

            // Andhra Pradesh
            ['city' => 'Visakhapatnam', 'state' => 'Andhra Pradesh', 'country' => 'India', 'latitude' => 17.6869, 'longitude' => 83.2185, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Vijayawada', 'state' => 'Andhra Pradesh', 'country' => 'India', 'latitude' => 16.5062, 'longitude' => 80.6480, 'timezone' => 'Asia/Kolkata'],

            // Karnataka
            ['city' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'latitude' => 12.9716, 'longitude' => 77.5946, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Mangalore', 'state' => 'Karnataka', 'country' => 'India', 'latitude' => 12.8628, 'longitude' => 74.8537, 'timezone' => 'Asia/Kolkata'],

            // Maharashtra
            ['city' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India', 'latitude' => 19.0760, 'longitude' => 72.8777, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Pune', 'state' => 'Maharashtra', 'country' => 'India', 'latitude' => 18.5204, 'longitude' => 73.8567, 'timezone' => 'Asia/Kolkata'],

            // Tamil Nadu
            ['city' => 'Chennai', 'state' => 'Tamil Nadu', 'country' => 'India', 'latitude' => 13.0827, 'longitude' => 80.2707, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Coimbatore', 'state' => 'Tamil Nadu', 'country' => 'India', 'latitude' => 11.0081, 'longitude' => 76.9124, 'timezone' => 'Asia/Kolkata'],

            // Uttar Pradesh
            ['city' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'latitude' => 28.7041, 'longitude' => 77.1025, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Lucknow', 'state' => 'Uttar Pradesh', 'country' => 'India', 'latitude' => 26.8467, 'longitude' => 80.9462, 'timezone' => 'Asia/Kolkata'],

            // Gujarat
            ['city' => 'Ahmedabad', 'state' => 'Gujarat', 'country' => 'India', 'latitude' => 23.0225, 'longitude' => 72.5714, 'timezone' => 'Asia/Kolkata'],
            ['city' => 'Surat', 'state' => 'Gujarat', 'country' => 'India', 'latitude' => 21.1702, 'longitude' => 72.8311, 'timezone' => 'Asia/Kolkata'],
        ];

        foreach ($locations as $location) {
            Location::firstOrCreate(
                ['city' => $location['city'], 'state' => $location['state']],
                $location
            );
        }
    }
}
