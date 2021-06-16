<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 100; $i++) {
            DB::table('subscribers')->insert([
                'email' => Str::random(10).'@gmail.com',
            ]);
        };


        for ($i=0; $i < 100; $i++) {
            DB::table('sections')->insert([
                'title' => Str::random(10),
            ]);
        };


        for ($i=0; $i < 50; $i++) {
            DB::table('section_subscriber')->insert([
                'section_id' => rand(1,100),
                'subscriber_id' => rand(1,100),
            ]);
        };
    }
}
