@extends('frontend.core.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-3">
                @if (Auth::user()->hasRole('Teacher'))
                    @foreach ($courses as $course)
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="fw-bold fs-5 mb-0">{{ $course->bab->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body fs-5">
                            <div class="mt-3 d-flex mb-0 p-0">
                                @forelse ($answers as $answer)
                                    <div class="me-2 text-center">
                                        <h6>From {{ $answer->user->name }}</h6>
                                        <a href="{{ url('download-answer/' . $answer->file_name) }}"
                                            class="btn btn-info mb-4 btn-sm">
                                            <i class="fas fa-download"></i>
                                            Download Jawaban .pdf
                                        </a>
                                    </div>
                                @empty
                                    <div class="container">
                                        <h5 class="fw-bold text-center">Jawaban dari murid masih kosong</h5>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url('dashboard/courses/' . $course->teacherCourse->name . '/show') }}"
                                class="btn btn-warning float-right align-item-end" role="button">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection
