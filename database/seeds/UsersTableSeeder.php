<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::firstOrNew(['email' => 'arief.hasnul@gmail.com']);
    	$user->name = "Hasnul Arief Fikri";
    	$user->password = bcrypt("123456");
    	$user->save();
    }
}