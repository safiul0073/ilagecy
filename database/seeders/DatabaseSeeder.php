<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'phone' => '+7 (999) 999-99-99',
            'password' => bcrypt('admin'),
            'role' => 'admin',
        ]);
    }
}
