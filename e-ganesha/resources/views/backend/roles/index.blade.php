@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('roles') }}
@endsection

@section('content')
    <div class="row">
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($roles as $role)
                            <li
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">
                                <label class="mt-auto mb-auto">
                                    {{ $role->name }}
                                </label>
                                <div>
                                    {{-- <a href="{{ url('dashboard/admin/roles/' . Str::lower($role->name)) }}"
                                        class="btn btn-sm btn-info" role="button">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ url('dashboard/admin/roles/' . Str::lower($role->name) . '/edit') }}"
                                        class="btn btn-sm btn-warning" role="button">
                                        <i class="fas fa-edit"></i>
                                    </a> --}}
                                </div>
                            </li>
                        @empty
                            <p class="text-center">
                                <strong>Data wewenang tidak tersedia</strong>
                            </p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
