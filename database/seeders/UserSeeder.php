<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 1000000; $i++) {
            User::create([
                'id' => Uuid::uuid4()->toString(), // Use UUID
                'name' => $faker->name,
                'avatar' => null, // Random image URL
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Default password
                'last_login_at' => $faker->dateTimeThisYear(), // Set to current time
                'last_login_ip' => $faker->ipv4, // Random IP
            ]);
        }
    }
}
