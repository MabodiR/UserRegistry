<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'surname' => $faker->lastName,
                'email' => $faker->unique()->email,
                'position' => $faker->jobTitle,
                'password' => bcrypt('secret'),
            ]);
        }
    }
}
