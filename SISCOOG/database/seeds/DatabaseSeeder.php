<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'name' => 'Carlos',
            'email' => 'carlos_henreis@outlook.com', 
            'password' => Hash::make('qwe123'), 
            'nascimento' => "1995-05-03", 
            'sexo' => 'M', 
            'ocupation' => "Estudante", 
        ]);

       DB::table('admins')->insert([
            'name' => 'Jean',
            'email' => 'jean@gmail.com', 
            'password' => Hash::make('qwe123'), 
        ]);
    }
}
