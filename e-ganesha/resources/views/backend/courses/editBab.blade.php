@extends('frontend.core.main')

@section('content')
    <div class="container">
        <div class="row justify-content-center my-4">
            <div class="col-lg-10">
                @foreach ($courses as $course)
                    <form action="{{ url('dashboard/courses/' . $course->id . '/update-bab') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="file_name" class="form-label">Jika <b>file</b>, Upload dalam bentuk format
                                <b>.pdf</b>
                            </label>
                            <input type="file" id="file_name" name="file_name"
                                class="form-control @error('file_name') is-invalid @enderror"
                                value="{{ old('file_name', asset('storage/course_file/' . $course->file_name)) }}">
                            @error('file_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Jika <b>fliphtml</b>, Upload
                                link
                                online
                                flipHtml
                            </label>
                            <input type="text" id="inputDescCourse" name="link_name"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Paste link disini...." value="{{ old('link_name', $course->link_name) }}">
                            @error('link_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="soal">
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea" class="form-label">
                                    Buat Soal
                                </label>
                                <textarea rows="5" id="summernote" name="soal"
                                    class="form-control @error('soal') is-invalid @enderror">{{ old('soal', $course->soal) }}</textarea>
                                @error('soal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="angkatan mb-3">
                            <label for="inputClassYears" class="form-label">Tahun Angkatan</label>
                            <select name="class_year_id" class="form-select @error('class_year_id') is-invalid @enderror">
                                <option value="" disabled selected>
                                    === Pilih Tahun Angkatan ===
                                </option>
                                @foreach ($classYears as $classYear)
                                    @if (old('class_year_id', $course->class_year_id) == $classYear->id)
                                        <option value="{{ $classYear->id }}" selected>
                                            {{ $classYear->name }}
                                        </option>
                                    @else
                                        <option value="{{ $classYear->id }}">
                                            {{ $classYear->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('class_year_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="inputBab" class="form-label">Bab</label>
                            <select name="bab_id" class="form-select @error('bab_id') is-invalid @enderror">
                                <option value="" disabled selected>=== Pilih Bab ===</option>
                                @foreach ($babs as $bab)
                                    @if (old('bab_id', $course->bab_id) == $bab->id)
                                        <option value="{{ $bab->id }}" selected>
                                            {{ $bab->name }}
                                        </option>
                                    @else
                                        <option value="{{ $bab->id }}">{{ $bab->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('bab_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="inputCourse" class="form-label">Course</label>
                            <select name="teacher_course_id" class="form-select">
                                <option value="{{ $course->teacher_course_id }}" selected>
                                    {{ $course->teacherCourse->name }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputRole" class="form-label">Untuk</label>
                            <select name="role_id" class="form-select">
                                <option value="{{ $course->role_id }}" selected>
                                    {{ $course->role->name }}
                                </option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="div">
                                <button type="submit" class="btn btn-dark">Update</button>
                            </div>
                            <div class="div">
                                <a href="{{ url('dashboard/courses/' . $course->teacherCourse->name . '/show') }}"
                                    class="btn btn-warning" role="button">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .note-editor .dropdown-toggle::after {
            all: unset;
        }

        .note-editor .note-dropdown-menu {
            box-sizing: content-box;
        }

        .note-editor .note-modal-footer {
            box-sizing: content-box;
        }

    </style>
@endpush

@push('scripts')
    {{-- Summernote --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Masukkan soal disini...',
                tabsize: 2,
                height: 200,
                popatmouse: true,

                styleTags: [
                    'p',
                    {
                        title: 'Blockquote',
                        tag: 'blockquote',
                        className: 'blockquote',
                        value: 'blockquote'
                    },
                    'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['codeview', 'help']],
                    ['height', ['height']],
                ]
            });
        });
    </script>
@endpush


@push('scripts')
    {{-- Preview file --}}
    <script>
        function previewImage() {
            const image = document.querySelector('#file_name');
            const imagePreview = document.querySelector('.img-preview');

            imagePreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }
        }
    </script>
@endpush
