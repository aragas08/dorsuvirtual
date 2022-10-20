<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'ginolabiste',
            'name' => 'Gino Labiste',
            'email' => 'gino.labiste@dorsu.edu.ph',
            'email_verified_at' => '',
            'type' => '',
            'password' => Hash::make('ginolabiste'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}