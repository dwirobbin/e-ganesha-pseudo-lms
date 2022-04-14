@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('teacher_show', $teacher) }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card my-1">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                        <i class="fas fa-id-badge fa-5x"></i>
                    </div>
                    <div class="col-md-10">
                        <table>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>{{ $teacher->name }}</td>
                            </tr>
                            <tr>
                                <th>Ttl</th>
                                <td>:</td>
                                <td>{{ $teacher->ttl }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>:</td>
                                <td>{{ $teacher->address }}</td>
                            </tr>

                            <tr>
                                <th>No. Hp</th>
                                <td>:</td>
                                <td>{{ $teacher->telephone_number }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td>{{ $teacher->email }}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>:</td>
                                <td>{{ $teacher->religion->name }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>:</td>
                                <td>{{ $teacher->gender->name }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>:</td>
                                <td>{{ $teacher->role->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <a href="{{ route('teachers.index') }}" class="btn btn-primary btn-sm border-0" role="button">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div>
                        <!-- edit -->
                        <a href="{{ route('teachers.edit', Str::lower($teacher->name)) }}"
                            class="btn btn-sm btn-warning me-1" role="button">
                            <i class="fas fa-edit"></i>
                        </a>
                        <!-- delete -->
                        <form action="{{ route('teachers.destroy', $teacher->name) }}" role="alert-delete" method="POST"
                            alert-text={{ Str::slug($teacher->name) }} class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Event : delete teacher
            $("form[role='alert-delete']").submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Peringatan !",
                    text: "Apakah anda yakin ingin menghapus user " + $(this).attr('alert-text') +
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
