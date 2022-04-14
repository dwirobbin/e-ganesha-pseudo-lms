@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('class_years') }}
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
                        <div class="col-md-12 d-flex justify-content-end pt-2 px-1">
                            <a href="{{ url('dashboard/admin/class-years/create') }}" class="btn btn-primary float-right"
                                role="button">
                                Tambah Angkatan
                                <i class="fas fa-plus-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($classYears as $classYear)
                            <li
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                                <label class="mt-auto mb-auto">
                                    {{ $classYear->name }}
                                </label>
                                <div>
                                    <form
                                        action="{{ url('dashboard/admin/class-years/' . $classYear->name . '/delete') }}"
                                        role="alert-delete" method="POST" alert-text={{ $classYear->name }}
                                        class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <p class="text-center">
                                <strong>Data tahun angkatan tidak tersedia</strong>
                            </p>
                        @endforelse
                    </ul>
                </div>
                @if ($classYears->hasPages())
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $classYears->links() }}
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
                    text: "Apakah anda yakin ingin menghapus tahun angkatan " + $(this).attr(
                            'alert-text') +
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
