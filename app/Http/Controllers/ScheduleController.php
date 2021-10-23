<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Role as RoleManualModel;
use App\Events\ScheduleUpdated;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:schedule-list|schedule-create|schedule-edit|schedule-destroy', ['only' => ['index','show']]);
         $this->middleware('permission:schedule-create', ['only' => ['create','store']]);
         $this->middleware('permission:schedule-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:schedule-destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::all();
        if (Auth::user()->role_id == RoleManualModel::ROLE_WORKER) {
            $schedules->where('user_id', Auth::user()->id);
            return view('worker',compact('schedules'));
        }
        return view('pages.schedules.index',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();

        $newSchedule = new Schedule();
        $newSchedule->user_id = $user->id;
        $newSchedule->title = $request['title'];
        $newSchedule->description = $request['description'];
        $newSchedule->start = Carbon::now();
        $newSchedule->end = Carbon::now();
        $newSchedule->save();

        event(new ScheduleUpdated($user)); // `ScheduleUpdated` broadcast event

        return redirect()->route('dashboard.schedules.index')->with('success','Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return view('pages.schedules.show',compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        return view('pages.schedules.edit',compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
         request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $user = Auth::user();

        $schedule->title = $request['title'];
        $schedule->description = $request['description'];
        $schedule->start = Carbon::now();
        $schedule->end = Carbon::now();
        $schedule->save();

        event(new ScheduleUpdated($user)); // `ScheduleUpdated` broadcast event

        return redirect()->route('dashboard.schedules.index')->with('success','Schedule updated successfully');
    }

    /**
     * Status Change the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request)
    {
        $schedule = Schedule::find($request['schedule_id']);
        $schedule->status = $request['schedule_status'];
        $schedule->save();
        return response()->json([ 'message' => 'ChangeScheduleStatusSuccess' ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('dashboard.schedules.index')->with('success','Schedule deleted successfully');
    }
}
