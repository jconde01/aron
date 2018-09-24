<?php

use Illuminate\Database\Seeder;
use App\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create([
           	'nombre' => 'Admin',
           	'activo' => true
        ]);
        Profile::create([
           	'nombre' => 'Segundo Perfil',
           	'activo' => true
        ],[
           	'nombre' => 'Tercer Perfil',
           	'activo' => true
        ]);              
    }
}
