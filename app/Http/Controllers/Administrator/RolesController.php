<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\AuthController;
use App\Role;
use App\Permission;


class RolesController extends AuthController
{

    public function __invoke(Request $request)
    {
        $permission = Permission::select(['id','name'])->get();

        $vue_component = "<roles-component :permissions='". json_encode($permission, JSON_HEX_APOS) ."'></roles-component>";

        return view('home', compact('vue_component'));
    }


    /**
     * Read Data
     * @param Request $request 
     * @return json
     */
    public function read(Request $request)
    {
        if($request->req == 'table') {
            $data = Role::where('name','like',"%$request->name%")
                        ->paginate($request->per_page);
            return response()->json(['model' => $data]);
        }

        if($request->req == 'table_detail'){
            $data = Role::find($request->id)->permissions()->get();
            return response()->json(['model' => $data]);
        }

        if($request->req == 'single'){
            $data = Role::find($request->id);
            return response()->json(['model' => $data]);
        }        
        
    }

    /**
     * Write Data
     * @param Request $request 
     * @return json
     */
    public function write(Request $request)
    {
        if($request->req == 'delete')
            return response()->json(Role::find($request->id)->delete());

        else if($request->req == 'write') {
            $this->validate($request,[
                'name'     => ['required', Rule::unique('roles')->ignore($request->id, 'id')]
            ]);

            $role = Role::find($request->id);

            if(!$role)
                $role = new Role();

            $role->name         = $request->name;
            $role->display_name = $request->display_name;
            $role->description  = $request->description;
            
            return response()->json($role->save());
        }

        elseif ($request->req == 'delete_detail') {
            return response()->json(Role::find($request->role_id)->detachPermission(Permission::find($request->id)));
        }

        elseif($request->req == 'add_detail') {
            
            $permission = Permission::find($request->id);

            $role = Role::find($request->role_id);

            if(!$role->permissions->contains($permission))
                $role->attachPermission($permission);

            return response()->json($role);
        }
        
       
    }

}
