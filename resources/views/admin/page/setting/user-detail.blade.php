@extends('admin.main.app')
@section('content')
@include('alert.message')

    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">User Profile</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('user.detail.index') }}">Accounts</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
    <!-- end page title -->

        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="profile-user-img position-relative">
                                    <img src="{{ asset('uploads/images/user/profile/' . $data['userDetail']->image) }}" alt="" class="rounded object-fit-cover">
                                    <span class="position-absolute top-0 start-100 translate-middle badge border border-3 border-white rounded-circle bg-success p-1 mt-1 me-1">
                                    </span>
                                </div>
                            </div><!--end col-->
                            <div class="col-lg-9">
                                <div class="d-flex border-bottom border-bottom-dashed pb-3 mb-3 mt-4 mt-lg-0">
                                    <div class="flex-grow-1">
                                        <h5>{{ $data['userDetail']->first_name }} {{ $data['userDetail']->middle_name }} {{ $data['userDetail']->last_name }}</h5>
                                        <p class="text-muted mb-0">{{ $data['userDetail']->designation }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown">
                                            <a href="{{ route('user.detail.edit', $data['userId']) }}" class="btn btn-success">Profile Edit</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Designation
                                                        </td>
                                                        <td class="fw-medium">
                                                            {{ $data['userDetail']->designation }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Location
                                                        </td>
                                                        <td class="fw-medium">
                                                            {{ $data['userDetail']->address }}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            Email ID
                                                        </td>
                                                        <td class="fw-medium">
                                                            {{ $data['userDetail']->email }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!--end col-->
                                    <div class="col-lg-6">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            Mobile / Phone No.
                                                        </td>
                                                        <td class="fw-medium">
                                                            {{ $data['userDetail']->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Joining Date
                                                        </td>
                                                        <td class="fw-medium">
                                                            {{ $data['userDetail']->created_at }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end row-->

                                <div class="mt-3">
                                    <ul class="list-unstyled hstack gap-2 mb-0">
                                        <li>
                                            Social Media:
                                        </li>
                                        <li>
                                            <a href="{{ $data['userDetail']->facebook }}" class="btn btn-soft-secondary btn-icon btn-sm" target="__blank"><i class="ph-facebook-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="mailto:{{ $data['userDetail']->email }}" class="btn btn-soft-danger btn-icon btn-sm"><i class="ph-envelope"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{ $data['userDetail']->twitter }}" class="btn btn-soft-primary btn-icon btn-sm"><i class="ph-twitter-logo"></i></a>
                                        </li>
                                        <li>
                                            <a href="{{ $data['userDetail']->whatsapp }}" class="btn btn-soft-success btn-icon btn-sm" target="__blank"><i class="ph-whatsapp-logo"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

@endsection
