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
        $administrator = App\Role::where('name', 'administrator')->first();

        $user = App\User::firstOrNew(['email' => 'arief.hasnul@gmail.com']);
    	$user->name = "Hasnul Arief Fikri";
    	$user->password = bcrypt("123456");
    	$user->save();
        $user->detachRoles();
        if($administrator)
            $user->attachRole($administrator);
        
        $user = App\User::firstOrNew(['email' => 'feisal.rz@gmail.com']);
        $user->name = "Feisal Reza";
        $user->password = bcrypt("123456");
        $user->save();
        $user->detachRoles();
        if($administrator)
            $user->attachRole($administrator);
    }
}