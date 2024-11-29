<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Input admin name: ') ;
        $email = $this->ask('Input admin email: ') ;
        $password = $this->secret('Input admin password') ;

        if( 
            User::where('email', $email)->exists()
        ){
            $this->error("User admin is already exists.") ;
            return 1 ;
        }

        $admin = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin'
        ]);

        $this->info("Admin user {$admin->email} created successfully.");
        return 0 ;
    }
}
