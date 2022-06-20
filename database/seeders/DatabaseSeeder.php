<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory()->create([
            'name' => 'Rauf Abbas',
            'email' => 'rauf@codio.az',
            'password' => bcrypt('password')
        ]);
         \App\Models\User::factory(10)->create();


    }
}
