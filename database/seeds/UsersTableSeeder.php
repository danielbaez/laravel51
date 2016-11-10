<?php

use Illuminate\Database\Seeder;

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
            'name' => 'Daniel Báez',
            'email' => 'daniel.baez@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 1,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'web'
        ]);
    }
}
