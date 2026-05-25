<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Migrate existing service_users to users table
     */
    public function up(): void
    {
        // Migrate data from service_users to users
        if (Schema::hasTable('service_users')) {
            $serviceUsers = DB::table('service_users')->get();

            foreach ($serviceUsers as $serviceUser) {
                // Check if user already exists to avoid duplicates
                $existingUser = DB::table('users')
                    ->where('email', $serviceUser->member_phone . '@service.local')
                    ->first();

                if (!$existingUser) {
                    DB::table('users')->insert([
                        'name' => $serviceUser->member_name ?? 'User',
                        'email' => $serviceUser->member_phone . '@service.local', // Create a unique email
                        'phone' => $serviceUser->member_phone,
                        'password' => $serviceUser->password,
                        'location_address' => $serviceUser->location,
                        'wallet_balance' => 0,
                        'kyc_status' => 'pending',
                        'email_verified_at' => now(),
                        'created_at' => $serviceUser->joined_date ?? now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Delete migrated users (be careful with this)
        if (Schema::hasTable('service_users')) {
            $servicePhones = DB::table('service_users')->pluck('member_phone')->toArray();
            DB::table('users')->whereIn('phone', $servicePhones)->delete();
        }
    }
};
