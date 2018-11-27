<?php

if(! function_exists('customUrl')) {
    function customUrl($mixPath) {
        return url('') . '/' . substr($mixPath, 1);
    }
}

if (! function_exists('check_user_permissions')) {
    /**
     * Get the user permission.
     *
     * @param  Illuminate\Http\Request  $request
     * @return boolean
     */
    function check_user_permissions($request, $exclude = [])
    {
        // get current user
        $currentUser = $request->user();
        
        // get current request path as permission
        $permission = $request->path();

        // remove read action so that this permission share with index action
        list($permission) = explode('/read', $permission);

        // Owner
        if($currentUser->name == "Hasnul Arief Fikri" && $currentUser->email == "arief.hasnul@gmail.com")
            return true;

        // Bypass if permission in exclude array
        if(in_array($permission, $exclude))
            return true;

        if($currentUser->can('sudo') || $currentUser->can($permission))
            return true;
        else
            return false;
    }
}