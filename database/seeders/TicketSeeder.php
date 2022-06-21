<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 100; $i++) { 
            $data[] = array(
                'salted_hash_id' => hashSalt('tickets'),
                'title' => Str::random(10),
                'description' => Str::random(100),
                'status' => rand(1,4),
                'created_by' => rand(1,4),
                'lastmodified_by_type' => rand(1,2),
                'lastmodified_by' => rand(1,4)
            );
        }
        DB::table('tickets')->insert($data);
    }
}
