@extends('admin.main.app')
@section('content')
@include('alert.message')

    <div class="row">
        <div class="col-xl-12 mx-auto">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Edit Permission</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission</a></li>
                                <li class="breadcrumb-item active">Edit Permission</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="{{ route('permission.update', $data['permission']->id) }}" method="POST" enctype="multipart/form-data">
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
                                        <h5 class="card-title mb-1">Permission Information</h5>
                                        <p class="text-muted mb-0">Fill all information below.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="col-12 mb-3">
                                    <x-form-field type="text" name="name" label="Name" :value="old('name', $data['permission']->name)" id="Name" />
                                </div>

                                <div class="col-12 mb-3">
                                    <x-form-field type="text" name="controller" label="Controller" :value="old('controller', $data['permission']->controller)" id="Controller"  />
                                </div>

                                <div class="col-12 mb-3">
                                    <x-form-field type="text" name="action" label="Action" :value="old('action', $data['permission']->action)" id="Action"  />
                                </div>

                                <div class="col-12 mb-3">
                                    <x-form-field type="text" name="group_name" label="Group Name" :value="old('group_name', $data['permission']->group_name)" id="GroupName"  />
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

