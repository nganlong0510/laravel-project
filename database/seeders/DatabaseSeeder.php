<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add 1 default user for debugging.
        User::create([
            'name' => 'Long',
            'email' => 'long@mail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ]);
        User::factory(10)->create();

        $this->call(CategorySeeder::class);
        $this->call(PostSeeder::class);
    }
}
