@extends('frontend.core.main')

@section('content')
    <div class="container col-lg-8" style="margin-top: 30px; margin-bottom: 5px">
        <form action="{{ url('dashboard/courses/store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="inputCourseName">Nama Kelas</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="inputCourseName"
                    placeholder="ex. Data Science">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group" style="margin-top: 10px;">
                <label for="exampleFormControlTextarea" class="form-label">Deskripsi</label>
                <textarea rows="5" id="summernote" name="description"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between my-3">
                <div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </div>
                <div>
                    <a href="{{ url('dashboard/courses/') }}" class="btn btn-warning float-right" role="button">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </form>
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
                placeholder: 'Masukkan deskripsi course...',
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
