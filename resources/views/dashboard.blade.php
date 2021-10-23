@extends('layouts.dashboard')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('a285e73e8b1d1c78629f', {
        cluster: 'ap2'
    });
    var channel = pusher.subscribe('leaderboard');
    channel.bind('ScheduleUpdateEvent', function(data) {
        $("#myTableBox").load(location.href + " #myTableBox");
        // $('#myTable').DataTable().destroy();
        // $('#myTable').DataTable().draw();
        // console.log(JSON.stringify(data));
    });
    </script>
@stop






@section('main_content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>


    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9 text-left">
                            <strong>Calendar</strong>
                        </div>
                        {{-- <div class="col-3 text-right">
                            <button type="button" class="btn btn-primary" name="button">Next Week</button>
                            <button type="button" class="btn btn-info text-white" name="button">Last Week</button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12" id="myTableBox">
                            <table id="myTable" class="table table-striped table-hover" width="100%">
                                @php
                                    $currentDate = Carbon\Carbon::now();
                                    $weekDate = Carbon\Carbon::now();
                                    Carbon\Carbon::setWeekStartsAt(Carbon\Carbon::MONDAY);
                                    Carbon\Carbon::setWeekEndsAt(Carbon\Carbon::SUNDAY);
                                    $monday = Carbon\Carbon::now()->startOfWeek();
                                    $tuesday = Carbon\Carbon::now()->startOfWeek()->add('1 days');
                                    $wednesday = Carbon\Carbon::now()->startOfWeek()->add('2 days');
                                    $thursday = Carbon\Carbon::now()->startOfWeek()->add('3 days');
                                    $friday = Carbon\Carbon::now()->startOfWeek()->add('4 days');
                                    $saturday = Carbon\Carbon::now()->startOfWeek()->add('5 days');
                                    $sunday = Carbon\Carbon::now()->endOfWeek();
                                @endphp
                                <thead>
                                    <tr>
                                        <th  width="10%" class="text-center">Role</th>
                                        <th  width="20%" class="text-center">Name</th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Monday") border text-success @endif">
                                            Monday
                                            <br>
                                            <span>{{ $monday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Tuesday") border text-success @endif">
                                            Tuesday
                                            <br>
                                            <span>{{ $tuesday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Wednesday") border text-success @endif">
                                            Wednesday
                                            <br>
                                            <span>{{ $wednesday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Thursday") border text-success @endif">
                                            Thursday
                                            <br>
                                            <span>{{ $thursday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Friday") border text-success @endif">
                                            Friday
                                            <br>
                                            <span>{{ $friday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Saturday") border text-success @endif">
                                            Saturday
                                            <br>
                                            <span>{{ $saturday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                        <th  width="10%" class="text-center @if ($currentDate->isoFormat('dddd') == "Sunday") border text-success @endif">
                                            Sunday
                                            <br>
                                            <span>{{ $sunday->isoFormat('MMM Do YYYY') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td width="10%">{{ $user->role->name }}</td>
                                            <td width="20%">{{ $user->name }}</td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Monday")
                                                    {{ $schedule->title }}
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Tuesday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Wednesday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Thursday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Friday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Saturday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                            <td width="10%">
                                            @foreach ($schedules->where('user_id', $user->id) as $key => $schedule)
                                                @if ($schedule->created_at->isoFormat('dddd') == "Sunday")
                                                    <span
                                                    @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                        class="badge bg-success"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                        class="badge bg-warning text-dark"
                                                    @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                        class="badge bg-danger"
                                                    @endif
                                                    onclick="ShowEditScheduleModal('{{ $schedule->id }}')" style="cursor: pointer;">
                                                    <strong title="{{ $schedule->description }}">{{ $schedule->title }}</strong>
                                                    </span>
                                                @endif
                                            @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Schedule Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form class="" action="index.html" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-control" name="schedule_status" id="schedule_status">
                                        <option value="{{ \App\Models\Schedule::STATUS_ALLOW }}">allow</option>
                                        <option value="{{ \App\Models\Schedule::STATUS_WAITING_CONFIRMATION }}">waiting_confirmation</option>
                                        <option value="{{ \App\Models\Schedule::STATUS_DENIED }}">denied</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.js" charset="utf-8"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        // $('#myTable').DataTable( {
        //     responsive: true
        // });
        function RefreshPage() {
            location.reload();
        }
        function ShowEditScheduleModal(id) {
            $('#exampleModal').modal('show');
            $('#schedule_status').attr('onchange', 'EditSchedule('+id+')');
        }
        function EditSchedule(id) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: documentRoot + '/dashboard/schedules/status/change',
                type: "POST",
                data: {
                    schedule_id : id,
                    schedule_status : $('#schedule_status').val()
                },
                success:function(data) {
                    RefreshPage();
                },
                error:function(data) {
                    alert('error');
                }
            });
        }
    </script>
@stop
