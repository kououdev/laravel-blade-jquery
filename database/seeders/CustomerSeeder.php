<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * How to Run => $ php artisan db:seed --class=CustomerSeeder
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Create 50 sample customers
        for ($i = 1; $i <= 50; $i++) {
            Customer::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
            ]);
        }
    }
}
