@extends('layouts.dashboard')


@section('main_content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard / Edit Schedule / {{ $schedule->title }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-primary" href="{{ route('dashboard.schedules.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong>Something went wrong.<br><br>
        <ul>
           @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
           @endforeach
        </ul>
      </div>
    @endif


    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>Edit Schedule / {{ $schedule->title }}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {!! Form::model($schedule,
                                [
                                    'method' => 'PATCH',
                                    'route' => ['dashboard.schedules.update', $schedule->id],
                                ]
                            ) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 p-2">
                                    <div class="form-group">
                                        <strong>Title:</strong>
                                        {!! Form::text('title', $schedule->title, array('placeholder' => 'Ttile','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 p-2">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        {!! Form::text('description', $schedule->description, array('placeholder' => 'Description','class' => 'form-control')) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-left mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
