<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vue_component = '<box-component></box-component>';
        return view('home', compact('vue_component'));
    }

    public function profile(Request $request)
    {
        $vue_component = "<profile-component :me='" . json_encode($request->user(), JSON_HEX_APOS) . "'></profile-component>";
        return view('home', compact('vue_component'));
    }

    public function writeProfile(Request $request)
    {
        $this->validate($request, [
            'old_password'     => 'required',
            'password'         => 'required',
            'confirm_password' => 'same:password'
        ]);

        $user = User::findOrFail($request->user()->id);

        if(!Hash::check($request->old_password, $user->password))
            return response()->json(['field' => 'old_password', 'text' => __('auth.old_password_error')], 422);

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json($user);
    }



    
}
