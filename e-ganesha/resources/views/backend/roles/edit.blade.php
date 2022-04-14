@extends('backend.core.main')

@section('title')
    {{ $title }}
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_role', $role) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 p-0">
            <div class="card">
                <form action="{{ url('dashboard/admin/roles/' . $role->name . '/update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="input_role_name" class="font-weight-bold">
                                <b>Role name</b>
                            </label>
                            <input id="input_role_name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $role->name) }}" />
                            @error('name')
                                <strong class="invalid-feedback">{{ $message }}</strong>
                            @enderror
                        </div>
                        <!-- permission -->
                        <div class="form-group mt-3">
                            <label for="input_role_permission" class="font-weight-bold">
                                <b>Permission</b>
                            </label>
                            <div class="form-control overflow-auto h-100 py-0  @error('permissions') is-invalid @enderror"
                                id="input_role_permission">
                                <div class="row">
                                    @foreach ($authorities as $manageName => $permissions)
                                        <div class="col-md-3 px-1 pt-2 pb-2 ">
                                            <!-- list manage name:start -->
                                            <ul class="list-group mx-1">
                                                <li class="list-group-item bg-dark text-white">
                                                    {{ $manageName }}
                                                </li>
                                                @foreach ($permissions as $permission)
                                                    <!-- list permission:start -->
                                                    <li class="list-group-item">
                                                        <div class="form-check">
                                                            <label for="{{ $permission }}" class="form-check-label">
                                                                {{ $permission }}
                                                            </label>
                                                            @if (old('permissions', $permissionChecked))
                                                                <input id="{{ $permission }}" class="form-check-input"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="{{ $permission }}"
                                                                    {{ in_array($permission, old('permissions', $permissionChecked)) ? 'checked' : null }}>
                                                            @else
                                                                <input id="{{ $permission }}" class="form-check-input"
                                                                    type="checkbox" name="permissions[]"
                                                                    value="{{ $permission }}">
                                                            @endif
                                                        </div>
                                                    </li>
                                                    <!-- list permission:end -->
                                                @endforeach
                                            </ul>
                                            <!-- list manage name:end  -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions')
                                <strong class="invalid-feedback">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="float-right mt-2 mb-4">
                            <a class="btn btn-warning px-3 me-2" href="{{ url('dashboard/admin/roles') }}">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-3">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
