<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           	'name' => 'Jorge Conde',
           	'email' => 'jconde1@gmail.com',
           	'password' => bcrypt('12345'),
           	'profile_id' => 1,
            'client_id' => 0,
           	'activo' => true
        ]);
    }
}
