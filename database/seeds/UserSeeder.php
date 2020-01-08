<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'name' => "Dwiki Likuisa",
            'email' => "dwiki@gmail.com",
            'password' => Hash::make("admin123")
        ],
        [
            'name' => "Aditya Hermawan",
            'email' => "aditya@gmail.com",
            'password' => Hash::make("admin123")
        ],
        [
            'name' => "MS Hendriyawan Achmad",
            'email' => "mrhendri@gmail.com",
            'password' => Hash::make("admin123")
        ]
        );
    }
}
