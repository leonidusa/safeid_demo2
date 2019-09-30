<?php

use Illuminate\Database\Seeder;

// php artisan db:seed --class=UsersTableSeeder
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Demo Admin',
            'email' => 'admin@test.com',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user' => false,
            'admin' => true,
            'password' => bcrypt('testing!'),
        ]);
        DB::table('users')->insert([
            'name' => 'demo user',
            'email' => 'user@test.com',            
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'password' => bcrypt('testing!'),
        ]);
    }
}
