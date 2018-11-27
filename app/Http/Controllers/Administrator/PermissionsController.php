<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AuthController;
use App\Permission;


class PermissionsController extends AuthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // if($request->user()->name == "Hasnul Arief Fikri" && $request->user()->email == "hasnul.rsusu@gmail.com"){
            $vue_component = "<permissions-component></permissions-component>";
            return view('home', compact('vue_component'));
        // }
        abort(404);
    }

    public function read(Request $request) {
        if($request->req == 'table') {
            
            $data = Permission::where('name', 'like', "%{$request->search}%")
                              ->paginate($request->per_page);
            
            return response()->json(['model' => $data]);
        }

        elseif($request->req == 'single') {
            $data = Permission::find($request->id);
            
            return response()->json(['model' => $data]);
        }
    }

    public function write(Request $request) {
        
        if($request->req == 'write') {
            $this->validate($request,[
                'name'      => 'required|unique:permissions,name,' . $request->id
            ]); 

            $data = Permission::find($request->id);

            if(!$data)
                $data = new Permission();

            $data->name         = $request->name;
            $data->display_name = $request->display_name;
            $data->description  = $request->description;

            $data->save();

            return response()->json($data);
        }

        elseif ($request->req == 'delete') {
            
            $data = Permission::findOrFail($request->id);

            return response()->json($data->delete());
        }
        
    }


}
