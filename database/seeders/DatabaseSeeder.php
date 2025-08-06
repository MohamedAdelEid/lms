<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dashboard\Category;
use App\Models\Dashboard\Course;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
//         Category::factory(50)->create();
//         Course::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       \App\Models\Admin\Admin::create([
           'first_name' => 'Mohamed',
           'last_name' => 'Saad',
           'email' => 'dev.mohamedsaad@gmail.com',
           'password' => Hash::make('Admin@123'),
           'phone_number' => '01098001021',
           'profile_picture'=>'1.jpg'
       ]);
    }
}
