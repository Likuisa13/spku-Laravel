<?php

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
        // $this->call(UsersTableSeeder::class);
        // $this->call(StasiunTableSeeder::class);
        // $this->call(PolusiSeeder::class);
        $this->call(UserSeeder::class);
        
    }
}
