@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('logs_activity') }}
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
                <div class="card-header p-2 ">
                    <div class="col-md-6">
                        <form action="#" method="GET">
                            <div class="input-group">
                                <input type="search" placeholder="Cari desc....." name="keyword"
                                    value="{{ request()->get('keyword') }}" class="form-control">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body px-2 pt-2 pb-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-sm align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Keterangan</th>
                                    <th>Waktu</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($activityLog as $item)
                                    <tr>
                                        <th scope="row">
                                            {{ ($activityLog->currentPage() - 1) * $activityLog->perPage() + $loop->iteration }}
                                        </th>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill bg-success fs-6 fw-normal p-1.">{{ $item->description }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-danger fs-6 fw-normal p-1.">
                                                {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </span>
                                        </td>
                                        <td>
                                            <form
                                                action="{{ url('dashboard/admin/logs-activity/' . $item->description . '/delete') }}"
                                                role="alert-delete" method="POST"
                                                alert-text="{{ $item->user->name . ' : ' . $item->description }}"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td scope="row" class="text-center fw-bold" colspan="5">
                                            @if (request()->get('keyword'))
                                                Deskripsi dengan nama {{ request()->get('keyword') }} tidak ditemukan
                                            @else
                                                Belum ada aktivitas apapun
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($activityLog->hasPages())
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $activityLog->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Event : delete log
            $("form[role='alert-delete']").submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Peringatan !",
                    text: "Apakah anda yakin ingin menghapus log user " + $(this).attr(
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
