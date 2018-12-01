<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Permission::firstOrCreate(['name' => 'users']);
        App\Permission::firstOrCreate(['name' => 'users/write']);
        App\Permission::firstOrCreate(['name' => 'roles']);
        App\Permission::firstOrCreate(['name' => 'roles/write']);

        $administrator = App\Role::firstOrCreate(['name' => 'Administrator']);
        $permissions = App\Permission::all();

        foreach ($permissions as $p) {
        	if(!$administrator->permissions->contains($p))
        		$administrator->attachPermission($p);
        }
    }
}
