@extends('admin.main.app')
@section('content')
@include('alert.message')

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit User</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">user</a></li>
                                <li class="breadcrumb-item active">Edit user</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <form action="{{ route('user.update', $data['user']->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-sm">
                                            <div class="avatar-title rounded-circle bg-light text-primary fs-20">
                                                <i class="bi bi-box-seam"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-1">User Information</h5>
                                        <p class="text-muted mb-0">Fill all information below.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body row">

                                <div class="col-md-6 mb-3">
                                    <x-form-field type="text" name="name" label="User Name" :value="old('name', $data['user']->name)" id="UserName" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <x-form-field type="email" name="email" label="User Email" :value="old('email', $data['user']->email)" id="UserEmail"  />
                                </div>

                                <!-- Password (Optional for Edit) -->
                                <div class="col-md-12 mb-3">
                                    <label for="password" class="form-label">Password(update password)</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                        placeholder="">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <x-form-field type="select" name="role_id" id="role_id"
                                        label="Select Role" :options="$data['roles']->pluck('name', 'id')->prepend('Select Role', '')" :selected="old('role_id', $data['user']->role_id)" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="Status" class="form-label">Select Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1" {{ $data['user']->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $data['user']->status == 0 ? 'selected' : '' }}>InActive</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
