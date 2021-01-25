@extends('layouts.app')

@section('title', 'Profile')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                            <p class="text-center">Név: {{Auth::user()->name}} </p>
                            <p class="text-center">e-mail: {{Auth::user()->email}} </p>
                            <p class="text-center">role: {{Auth::user()->is_admin ? "admin" : "user"}} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection