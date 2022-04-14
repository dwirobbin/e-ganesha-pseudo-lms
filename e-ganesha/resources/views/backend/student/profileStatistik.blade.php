@extends('frontend.core.main')

@section('content')
    <section class="profile-info">
        <div class="container">
            <div class="row">

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @foreach ($profilesStudent as $profileStudent)
                    <div class="col-lg-4">
                        <div class="edit-foto">
                            <div class="gambar-siswa">
                                @if ($profileStudent->image)
                                    <img src="{{ asset('storage/image_profile/' . $profileStudent->image) }}" alt="">
                                @else
                                    <img src="{{ asset('frontend/img/pf.jfif') }}" alt="#">
                                @endif
                            </div>
                            <div class="text">
                                <h5>{{ $profileStudent->name }}</h5>
                                <form action="{{ url('dashboard/student/profile-siswa/' . $profileStudent->name) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <label for="inputImage">Ubah Foto Profil</label>
                                    <input type="file" id="inputFile" name="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        value="{{ old('image') }}">
                                    @error('image')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                    <button class="btn btn-primary btn-sm mt-2">
                                        Update Photo
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="col-lg-12">
                            <div class="informations">
                                <div class="informasi-siswa">
                                    <i class="fas fa-info-circle fa-3x"></i>
                                    <a href="{{ url('dashboard/student/profile-siswa') }}">Informasi Siswa</a>
                                </div>
                                <div class="statistik-siswa">
                                    <div class="statistik-siswa">
                                        <i class="fas fa-signal fa-2x"></i>
                                        <a href="profil-statistik.html">Statistik Siswa</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Bab</th>
                                    <th scope="col">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($answers as $answer)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $answer->teacherCourse->name }}</td>
                                        <td>{{ $answer->bab->name }}</td>
                                        @if (isset($answer->file_name))
                                            <td>
                                                <span class="badge rounded-pill bg-success fs-6 fw-normal p-1.">100
                                                </span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge rounded-pill bg-danger fs-6 fw-normal p-1.">0
                                                </span>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td scope="row" class="text-center fw-bold" colspan="4">
                                            Anda belum pernah mengumpul jawaban apapun
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
