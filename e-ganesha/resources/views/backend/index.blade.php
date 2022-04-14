@extends('backend.core.main')

@section('title')
    Welcome Back {{ Auth::user()->name }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard_admin') }}
@endsection

@section('content')
    <div class="row mt-0">
        <div class="col-lg-4 col-sm-6 mt-0">
            <div class="card-box bg-blue">
                <div class="inner">
                    <h3> Jumlah Guru </h3>
                    <p> {{ $totalTeacher }} </p>
                </div>
                <div class="icon">
                    <i class="fa fa-chalkboard-teacher" aria-hidden="true"></i>
                </div>
                <a href="{{ route('teachers.index') }}" class="card-box-footer">
                    View More
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-green">
                <div class="inner">
                    <h3> Jumlah Murid </h3>
                    <p> {{ $totalStudent }} </p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-graduate" aria-hidden="true"></i>
                </div>
                <a href="{{ route('students.index') }}" class="card-box-footer">
                    View More
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-sm-6">
            <div class="card-box bg-orange">
                <div class="inner">
                    <h3> Jumlah Course </h3>
                    <p> {{ $totalCourse }} </p>
                </div>
                <div class="icon">
                    <i class="fa fa-book" aria-hidden="true"></i>
                </div>
                <a href="{{ url('dashboard/admin/courses') }}" class="card-box-footer">
                    View More
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Selamat Datang Kembali <b>{{ Auth::user()->name }}</b>
                    </h6>
                </div>
                <div class="card-body">
                    <p>Semoga <b>{{ Auth::user()->name }}</b> selalu dalam lindungan tuhan yang maha esa, di sini
                        <b>{{ Auth::user()->name }}</b> dapat melakukan apapun sesuai dengan wewenang yang dimiliki.
                    </p>
                    <p class="mb-0">
                        Harap gunakan web sisfo <b>{{ config('app.name') }}</b> ini dengan sangat
                        bijak.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card-box {
            position: relative;
            color: #fff;
            padding: 20px 10px 40px;
            margin: 20px 0px;
            border-radius: 4px;
        }

        .card-box:hover {
            text-decoration: none;
            color: #f1f1f1;
        }

        .card-box:hover .icon i {
            font-size: 100px;
            transition: 1s;
            -webkit-transition: 1s;
        }

        .card-box .inner {
            padding: 5px 10px 0 10px;
        }

        .card-box h3 {
            font-size: 27px;
            font-weight: bold;
            margin: 0 0 8px 0;
            white-space: nowrap;
            padding: 0;
            text-align: left;
        }

        .card-box p {
            font-size: 20px;
        }

        .card-box .icon {
            position: absolute;
            top: auto;
            bottom: 5px;
            right: 5px;
            z-index: 0;
            font-size: 72px;
            color: rgba(0, 0, 0, 0.15);
        }

        .card-box .card-box-footer {
            position: absolute;
            left: 0px;
            bottom: 0px;
            text-align: center;
            padding: 3px 0;
            color: rgba(255, 255, 255, 0.8);
            background: rgba(0, 0, 0, 0.1);
            width: 100%;
            text-decoration: none;
        }

        .card-box:hover .card-box-footer {
            background: rgba(0, 0, 0, 0.3);
        }

        .bg-blue {
            background-color: #00c0ef !important;
        }

        .bg-green {
            background-color: #00a65a !important;
        }

        .bg-orange {
            background-color: #f39c12 !important;
        }

        .bg-red {
            background-color: #d9534f !important;
        }

    </style>
@endpush
