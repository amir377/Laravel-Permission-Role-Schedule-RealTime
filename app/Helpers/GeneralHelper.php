<?php
use Illuminate\Support\Facades\Auth;


if (!function_exists('checkPermission'))
{
    function checkPermission($permissionNames)
    {
        if(!Auth::check()){
            return false;
        }
        $permissionNames = (array)$permissionNames;
        static $premissions;
        if(empty($premissions)){
            $premissions = auth()->user()->role->permissions;
        }
        foreach($permissionNames as $permissionStart){
            foreach($premissions as $permission){
                if(stristr($permission->name, $permissionStart)){
                    return true;
                }
            }
        }
        return false;
    }
}
