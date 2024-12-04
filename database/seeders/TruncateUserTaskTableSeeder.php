<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TruncateUserTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Disable foreign key checks to avoid issues with foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the usertask table
        DB::table('user_tasks')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
//php artisan db:seed --class=TruncateUserTaskTableSeeder
