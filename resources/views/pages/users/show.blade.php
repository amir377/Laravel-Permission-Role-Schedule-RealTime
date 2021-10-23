@extends('layouts.dashboard')


@section('main_content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard / Show User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a class="btn btn-primary" href="{{ route('dashboard.users.index') }}"> Back</a>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="card-text">
                                <strong>Email:</strong>
                                {{ $user->email }}
                            </p>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <strong>Roles:</strong>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <label class="badge bg-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
