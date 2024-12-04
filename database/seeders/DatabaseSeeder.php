<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        // Truncate the usertask table
        DB::table('user_tasks')->truncate();
        // Truncate the tasks table
        Task::truncate('tasks')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::factory(5)->create();
        // Create 50 tasks
        Task::factory()->count(50)->create();

    }
}
