@extends('frontend.core.main')

@section('content')
    <section class="course-finder">
        <div class="container col-lg-8">
            <div class="course-search">
                <h5>Course Finder</h5>
                <form action="{{ url('dashboard/courses') }}" method="GET">
                    <div class="input-group">
                        <input name="keyword" value="{{ request()->get('keyword') }}" type="search" class="form-control"
                            placeholder="Search course.....">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if (Auth::user()->hasRole('Teacher'))
                <div class="request-course">
                    <h5>Buat Kelas</h5>
                    <a href="{{ url('dashboard/courses/create') }}" role="button" class="btn btn-request">
                        <i class="fas fa-plus-square"></i>
                        Buat Kelas
                    </a>
                </div>
            @endif

            @if (Auth::user()->hasRole('Student'))
                <div class="col-lg-3 p-0">
                    <div class="info-navigation">
                        <div class="profil-siswa">
                            <i class="fas fa-user fa-2x"></i>
                            <a href="{{ url('dashboard/student/profile-siswa') }}" class="text-decoration-none fw-bold">
                                Profil Siswa
                            </a>
                        </div>
                        <div class="log-out">
                            <form action="{{ url('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item p-0">
                                    <i class="fas fa-sign-out-alt fa-2x"></i>
                                    <h6 class="link-primary d-inline fw-bold">Logout</h6>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <hr>
    </section>

    <section class="course-overview">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">

                    @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <h2 style="font-size: 24px;">Course Overview</h2>
                    <div class="card-overview">
                        @forelse ($teacherCourses as $teacherCourse)
                            <div class="cad">
                                <a href="{{ url('dashboard/courses/' . $teacherCourse->name) }}"
                                    style="text-decoration: none; color: black;">
                                    <div class="course-card">
                                        <div class="card-image">
                                            <img src="{{ asset('frontend/img/card-img.jfif') }}" alt="">
                                        </div>
                                        <div class="d-flex justify-content-between py-1 pe-1">
                                            <div class="card-description">
                                                <h6>{{ $teacherCourse->name }}</h6>
                                            </div>

                                            <div class="card-description d-flex">
                                                @if (auth()->user()->hasRole('Teacher'))
                                                    <a href="{{ url('dashboard/courses/' . $teacherCourse->name . '/edit') }}"
                                                        class="btn btn-warning btn-sm me-1">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form
                                                        action="{{ url('dashboard/courses/' . $teacherCourse->name . '/delete') }}"
                                                        role="alert-delete" method="POST"
                                                        alert-text={{ Str::slug($teacherCourse->name) }}>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <strong>
                                @if (request()->get('keyword'))
                                    <p>
                                        Course dengan nama {{ request()->get('keyword') }} tidak ditemukan
                                    </p>
                                @else
                                    <p>Course belum tersedia</p>
                                @endif
                            </strong>
                        @endforelse
                    </div>
                </div>
                @if ($teacherCourses->hasPages())
                    <div class="d-flex justify-content-end pb-0 mt-2">
                        {{ $teacherCourses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Event : delete course
            $("form[role='alert-delete']").submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Peringatan !",
                    text: "Apakah anda yakin ingin menghapus course " + $(this).attr('alert-text') +
                        " ?",
                    icon: 'warning',
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    reverseButtons: true,
                    confirmButtonText: "Yes",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.submit();
                    }
                });
            });
        });
    </script>
@endpush
