<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Role as RoleManualModel;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;

class HomeController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    **/
    public function index()
    {
        if (Auth::user()->role_id == RoleManualModel::ROLE_ADMIN) {
            $users = User::all()->where('id', '!=', Auth::user()->id);
            $schedules = Schedule::all()->where('user_id', '!=', Auth::user()->id);
            return view('dashboard', compact('users', 'schedules'));
        }elseif (Auth::user()->role_id == RoleManualModel::ROLE_WORKER) {
            $users = User::all()->where('id', '=', Auth::user()->id);
            $schedules = Schedule::all()->where('user_id', '=', Auth::user()->id);
            return view('worker', compact('users', 'schedules'));
        }
    }


    public function leaderboard () {
        // return UserCollection::make(User::all());
        return User::all();
    }
}
