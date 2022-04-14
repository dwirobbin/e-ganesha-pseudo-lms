@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('students') }}
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header pt-0 ">
                    <div class="row ">
                        <div class="col-md-6 px-1">
                            <form action="{{ route('students.index') }}" method="GET">
                                <div class="input-group pt-2">
                                    <input name="keyword" value="{{ request()->get('keyword') }}" type="search"
                                        class="form-control" placeholder="Cari murid.....">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end pt-2 px-1">
                            <a href="{{ route('students.create') }}" class="btn btn-primary float-right" role="button">
                                Tambah murid
                                <i class="fas fa-plus-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Tahun Angkatan</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $student)
                                    <tr>
                                        <th scope="row">
                                            {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                        </th>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->gender->name }}</td>
                                        <td>{{ $student->classYear->name }}</td>
                                        <td>
                                            <a href="{{ route('students.show', Str::lower($student->name)) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('students.edit', Str::lower($student->name)) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('students.destroy', $student->name) }}"
                                                role="alert-delete" method="POST"
                                                alert-text={{ Str::slug($student->name) }} class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td scope="row" class="text-center fw-bold" colspan="6">
                                            @if (request()->get('keyword'))
                                                Murid dengan nama {{ request()->get('keyword') }} belum terdaftar
                                            @else
                                                Seluruh data murid belum tersedia
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($students->hasPages())
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Event : delete student
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
