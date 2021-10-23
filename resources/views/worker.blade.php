@extends('layouts.dashboard')


@section('main_content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard / Schedules Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-success" href="{{ route('dashboard.schedules.create') }}"> Create New Schedule</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>Schedules List</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th width="280px">Action</th>
                                </tr>
                                @foreach ($schedules as $key => $schedule)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $schedule->title }}</td>
                                        <td>{{ $schedule->description }}</td>
                                        <td>
                                            @if ($schedule->status == \App\Models\Schedule::STATUS_ALLOW)
                                                ALLOW
                                            @elseif ($schedule->status == \App\Models\Schedule::STATUS_WAITING_CONFIRMATION)
                                                WAITING_CONFIRMATION
                                            @elseif ($schedule->status == \App\Models\Schedule::STATUS_DENIED)
                                                DENIED
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('dashboard.schedules.destroy',$schedule->id) }}" method="POST">
                                                @can('schedule-edit')
                                                    <a class="btn btn-primary" href="{{ route('dashboard.schedules.edit',$schedule->id) }}">Edit</a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can('schedule-destroy')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-12">
                            {{-- {!! $schedules->links() !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
