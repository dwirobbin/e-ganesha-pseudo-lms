@extends('frontend.core.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-3">

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="theme-text " style="text-align: center;">
                    <div class="title-judul">
                        <h4 style="color: black" class="fs-2 fw-bold">
                            {{ $teacherCourse->name }}
                        </h4>
                    </div>
                    <div class="deskripsi-mk" style="text-align: justify">
                        {!! $teacherCourse->description !!}
                    </div>
                </div>

                <div class="card mt-5">
                    @forelse ($courses as $course)
                        @if (Auth::user()->hasRole('Student') && auth()->user()->classYear->name == $course->classYear->name)
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-fill">
                                        <p class="fw-bold fs-5 mb-0">{{ $course->bab->name }}</p>
                                    </div>
                                    <div class="flex-fill">
                                        <p class="fw-bold fs-5 mb-0">
                                            {{ $course->classYear->name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body fs-5">
                                @if (isset($course->link_name))
                                    <a href="{{ $course->link_name }}" class="btn btn-info mb-4 btn-sm">
                                        <i class="fas fa-download"></i>
                                        Download Materi via FlipHtml
                                    </a>
                                @else
                                    <a href="{{ url('download/' . $course->file_name) }}"
                                        class="btn btn-info mb-4 btn-sm">
                                        <i class="fas fa-download"></i>
                                        Download Materi .pdf
                                    </a>
                                @endif
                                <br>
                                <p>
                                    <strong class="fw-bold">
                                        Soal untuk mahasiswa angkatan tahun {{ $course->classYear->name }}
                                    </strong>
                                </p>
                                {!! $course->soal !!}
                                <small class="d-inline fst-italic">
                                    <p class="m-0">Dibuat
                                        <span class="badge rounded-pill bg-secondary fw-normal mt-0 fst-italic">
                                            {{ Carbon\Carbon::parse($course->created_at)->diffForHumans() }}
                                        </span>
                                    </p>
                                </small>
                                <div class="mt-4">
                                    <form
                                        action="{{ url('dashboard/courses/' . $teacherCourse->name . '/' . $course->id . '/student/uploadFile') }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <label for="file_name" class="form-label">
                                            <h6>Upload jawaban</h6>
                                            <h6>*Harus <b>word, pdf</b></h6>
                                        </label>
                                        <input type="file" id="file_name" name="file_name"
                                            class="form-control @error('file_name') is-invalid @enderror mt-0"
                                            value="{{ old('file_name') }}">
                                        @error('file_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <button type="submit" class="btn btn-primary mt-3">Upload Jawaban</button>
                                    </form>
                                </div>
                            </div>
                            <br>
                        @elseif (Auth::user()->hasRole('Teacher'))
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-fill">
                                        <p class="fw-bold fs-5 mb-0">{{ $course->bab->name }}</p>
                                    </div>
                                    <div class="flex-fill">
                                        <p class="fw-bold fs-5 mb-0">
                                            {{ $course->classYear->name }}
                                        </p>
                                    </div>
                                    <div class="d-flex">
                                        @if (auth()->user()->hasRole('Teacher'))
                                            <div class="me-2">
                                                <a href="{{ url('dashboard/courses/' . $course->id . '/edit-bab') }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                            <div>
                                                <form
                                                    action="{{ url('dashboard/courses/' . $course->id . '/delete-bab') }}"
                                                    role="alert-delete" method="POST"
                                                    alert-text={{ Str::slug($course->bab->name) }}>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body fs-5">
                                @if (isset($course->link_name))
                                    <a href="{{ $course->link_name }}" class="btn btn-info mb-4 btn-sm">
                                        <i class="fas fa-download"></i>
                                        Download Materi via FlipHtml
                                    </a>
                                @else
                                    <a href="{{ url('download/' . $course->file_name) }}"
                                        class="btn btn-info mb-4 btn-sm">
                                        <i class="fas fa-download"></i>
                                        Download Materi .pdf
                                    </a>
                                @endif
                                <br>
                                <p>
                                    <strong class="fw-bold">
                                        Soal untuk mahasiswa angkatan tahun {{ $course->classYear->name }}
                                    </strong>
                                </p>
                                {!! $course->soal !!}
                                <small class="d-inline fst-italic">
                                    <p class="m-0">Dibuat
                                        <span class="badge rounded-pill bg-secondary fw-normal mt-0 fst-italic">
                                            {{ Carbon\Carbon::parse($course->created_at)->diffForHumans() }}
                                        </span>
                                    </p>
                                </small>
                                <div class="me-2 text-center">
                                    <a href="{{ url('dashboard/courses/' . 'done-upload-answers/' . $course->id) }}"
                                        class="btn btn-warning mb-4 btn-sm">
                                        <i class="fas fa-eye"></i>
                                        Lihat jawaban murid
                                    </a>
                                </div>
                            </div>
                            <br>
                        @else
                            <div class="card-header text-center">
                                <p class="fs-6 mb-0">
                                    Anda bukan siswa angkatan tahun {{ $course->classYear->name }}
                                </p>
                            </div>
                        @endif
                    @empty
                        <div class="card-header text-center">
                            <p class="fs-6 mb-0">
                                Data course {{ $teacherCourse->name }} belum tersedia
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="d-flex justify-content-between my-3">
                @if (Auth::user()->hasRole('Teacher'))
                    <div>
                        <a href="{{ url('dashboard/courses/' . $teacherCourse->name . '/create') }}"
                            class="btn btn-primary float-right" role="button">
                            <i class="fas fa-plus-square"></i>
                            Tambah Data
                        </a>
                    </div>
                @endif
                <div>
                    <a href="{{ url('dashboard/courses/' . $teacherCourse->name) }}" class="btn btn-warning float-right"
                        role="button">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Event : delete bab
            $("form[role='alert-delete']").submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Peringatan !",
                    text: "Apakah anda yakin ingin menghapus " + $(this).attr('alert-text') +
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
