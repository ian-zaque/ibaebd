<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Secretaria IBA',
            'email' => 'ibalvorada1242@gmail.com',
            'password' => Hash::make('secibajo316'),
        ]);

        DB::table('users')->insert([
            'name' => 'MEC IBA',
            'email' => 'cidaeleli88@outlook.com',
            'password' => Hash::make('mecibajo316'),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admingn11'),
        ]);

    }
}
