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

        DB::table('users')->insert([
            'name' => 'Any Ugarte',
            'email' => 'any.ugarte@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'movil'
        ]);

        DB::table('users')->insert([
            'name' => 'Wendy Sotomayor',
            'email' => 'wendy.sotomayor@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'movil'
        ]);

        DB::table('users')->insert([
            'name' => 'Fiorella Montenegro',
            'email' => 'fiorella.montenegro@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 0,
            'method_call' => 'web'
        ]);

        DB::table('users')->insert([
            'name' => 'Alexandra Delgado',
            'email' => 'alexandra.delgado@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 0,
            'method_call' => 'web'
        ]);

        DB::table('users')->insert([
            'name' => 'Skandia Consiglieri',
            'email' => 'skandia.consiglieri@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'movil'
        ]);

        DB::table('users')->insert([
            'name' => 'Diana Sandoval',
            'email' => 'diana.sandoval@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 0,
            'method_call' => 'movil'
        ]);

        DB::table('users')->insert([
            'name' => 'Anibal Morante',
            'email' => 'anibal.morante@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'movil'
        ]);

        DB::table('users')->insert([
            'name' => 'Catherine Escobar',
            'email' => 'catherine.escobar@comparabien.com',
            'password' => Hash::make(12345678),
            'type' => 2,
            'company_id' => 0,
            'country' => 'pe',
            'phone_pe' => '999999999',
            'active' => 1,
            'method_call' => 'movil'
        ]);
    }
}
