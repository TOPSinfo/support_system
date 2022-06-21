<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = array(
            'name' => 'Vijahat',
            'email' => 'vijahat@topsinfosolutions.com',
            'is_admin' => '1',
            'password' => Hash::make('password'),
        );
        $data[] = array(
            'name' => 'Test',
            'email' => 'testvijahat@gmail.com',
            'password' => Hash::make('password'),
        );
        $data[] = array(
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        );
        $data[] = array(
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        );
        $data[] = array(
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
        );
        DB::table('users')->insert($data);
    }
}
