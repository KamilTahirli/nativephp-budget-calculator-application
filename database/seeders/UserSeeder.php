<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = "admin@gmail.com";

        if (!$user = User::where('email', $email)->exists()) {
            User::create([
                'name' => "Admin",
                'email' => "admin@gmail.com",
                'email_verified_at' => now(),
                'password' => bcrypt('admin555'),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
