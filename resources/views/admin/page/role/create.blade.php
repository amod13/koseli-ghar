@extends('admin.main.app')
@section('content')
@include('alert.message')
<div class="row">
    <div class="col-xl-12 mx-auto">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Role</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Role</a></li>
                            <li class="breadcrumb-item active">Create Role</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <form action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <h5 class="card-title mb-1">Role Information</h5>
                                    <p class="text-muted mb-0">Fill all information below.</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="col-12 mb-3">
                                <x-form-field type="text" name="name" label="Name" :value="old('name')" id="title" :placeholder="'Add Role Name'" />
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
