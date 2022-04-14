@extends('frontend.core.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-4">

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="theme-text " style="text-align: center;">
                    <div class="title-judul">
                        <h4 style="color: black" class="fw-bold fs-3">
                            {{ $teacherCourse->name }}
                        </h4>
                    </div>
                    <div class="deskripsi-mk" style="text-align: justify">
                        {!! $teacherCourse->description !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 d-flex justify-content-between mb-2">
            <div>
                @if (Auth::user()->hasRole('Teacher'))
                    <a href="{{ url('dashboard/courses/' . $teacherCourse->name . '/create') }}"
                        class="btn btn-primary float-right" role="button">
                        <i class="fas fa-plus-square"></i>
                        Tambah Data
                    </a>
                @endif
                <a href="{{ url('dashboard/courses/' . $teacherCourse->name . '/show') }}"
                    class="btn btn-info float-right" role="button">
                    <i class="fas fa-eye"></i>
                    Lihat Data
                </a>
            </div>
            <div>
                <a href="{{ url('dashboard/courses') }}" class="btn btn-warning float-right align-item-end" role="button">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
