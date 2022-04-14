@extends('frontend.core.main')

@section('content')
    <div class="text">
        <h6>Welcome To {{ config('app.name') }}</h6>
    </div>
    <div class="slider">
        <div class="item">
            <img src="{{ asset('frontend/img/u2.jfif') }}" alt="" />
        </div>
    </div>
@endsection
