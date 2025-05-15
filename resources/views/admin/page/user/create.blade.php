@extends('admin.main.app')
@section('content')
@include('alert.message')

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create User</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">user</a></li>
                                <li class="breadcrumb-item active">Create user</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                    <x-form-field type="text" name="name" label="User Name" :value="old('name')" id="UserName" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <x-form-field type="email" name="email" label="User Email" :value="old('email')" id="UserEmail"  />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="UserName" class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Password*" id="Password" name="password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="UserName" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Confirm Password*" id="" name="password_confirmation" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <x-form-field type="select" name="role_id" id="role_id"
                                        label="Select Role" :options="$data['roles']->pluck('name', 'id')->prepend('Select Role', '')" :selected="old('role_id')" />
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="Status" class="form-label">Select Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <!-- end card -->
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-sm">Submit</button>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
            </form>
        </div>
    </div>
@endsection
