<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstructorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Adel',
                'email' => 'mohamed.adel@example.com',
                'password' => Hash::make('mohamedadel@password'),
                'phone_number' => '123456789',
                'profile_picture' => 'mohamed_adel_profile.jpg',
                'qualifications' => 'MBA in Finance',
            ],
            [
                'first_name' => 'Ahmed',
                'last_name' => 'Ezz',
                'email' => 'Mohamed.Ezz@example.com',
                'password' => Hash::make('mohamed.ezz@password'),
                'phone_number' => '123456789',
                'profile_picture' => 'ahmed_ezz_profile.jpg',
                'qualifications' => 'Ph.D. in Economics',
            ],
            [
                'first_name' => 'Ali',
                'last_name' => 'Fawzy',
                'email' => 'ali.fawzy@example.com',
                'password' => Hash::make('ali.fawzy@gmail.com'),
                'phone_number' => '01126509296',
                'profile_picture' => 'ali_fawzy_profile.jpg',
                'qualifications' => 'Financial Risk Manager',
            ],
            [
                'first_name' => 'Mohamed',
                'last_name' => 'Saad',
                'email' => 'mohamed.saad@example.com',
                'password' => Hash::make('mohamed.saad@password'),
                'phone_number' => '01098001021',
                'profile_picture' => 'mohamed_saad_profile.jpg',
                'qualifications' => 'Master in Economics',
            ],

            // Add other instructors here...
        ];
        foreach ($instructors as $instructor){
            DB::table('instructors')->insert($instructor);
        }
    }
}
