<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\User;
use App\Role;

class UsersController extends AuthController
{
    public function __invoke()
    {
        $roles = Role::select('id','name')->get();
        $vue_component = "<users-component  :roles='" . json_encode($roles, JSON_HEX_APOS) . "'></users-component>";
        return view('home', compact('vue_component'));
    }

    public function read(Request $request)
    {
        if($request->req == 'table') {
            $data = User::withTrashed()
                            ->leftJoin('role_user', 'role_user.user_id','=','users.id')
                            ->leftJoin('roles','roles.id','=','role_user.role_id')
                            ->where('users.name','like',"%$request->search%")
                            ->orWhere('email','like',"%$request->search%")
                            ->orWhere('roles.name','like',"%$request->search%")
                            ->select(['users.*','roles.name as role_name'])
                            ->paginate($request->per_page);

            return response()->json(['model' => $data]);
        }

        elseif($request->req == 'single') {
            $data = User::withTrashed()->find($request->id);
            return response()->json(['model' => $data]);
        }

        

    }

    public function write(Request $request)
    {
        if($request->req == 'delete')
            return response()->json(User::find($request->id)->delete());
        else if($request->req == 'activate')
            return response()->json(User::onlyTrashed()->find($request->id)->restore());
        else if($request->req == 'write') {
             $this->validate($request,[
                'name'             => 'required',
                'email'            => 'required|email|unique:users,email,' . $request->id,
                'password'         => 'required_without:id',
                'confirm_password' => 'same:password'
            ]);

            $user = User::find($request->id);

            if(!$user)
                $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            
            if($request->password)
                $user->password = bcrypt($request->password);        

            $user->detachRoles();

            if($request->role_id)
                $user->attachRole(Role::find($request->role_id));

            $user->save();
            return response()->json($user);
        }

    }
}
