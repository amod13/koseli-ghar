@extends('admin.main.app')
@section('content')
@include('alert.message')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User List</a></li>
                        <li class="breadcrumb-item active">User List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-15 w-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="mb-0">Search Filter</h5>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card radius-15 border shadow-none mb-0">
                            <div class="card-body">
                                <form action="{{ route('user.search') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        {{-- Search by Status --}}
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Select Status</label>
                                                <select class="form-select single-select" name="status" id="userStatus">
                                                    <option disabled selected>--- Select Status ---</option>
                                                        <option value="1" {{ old('status', request()->get('status')) == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ old('status', request()->get('status')) == '0' ? 'selected' : '' }}>InActive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="keyword" class="form-label">Search By Name</label>
                                                <input type="text" name="keyword" class="form-control" placeholder="search by name..." value="{{ old('keyword', request()->get('keyword')) }}">
                                            </div>
                                        </div>
                                        {{-- Submit and Reset --}}
                                        <div class="col-md-4">
                                            <div class="mb-3 d-flex align-items-end gap-2" style="margin-top: 33px;">
                                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                <a href="{{ route('user.index') }}"
                                                    class="btn btn-danger btn-sm">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table List --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title d-flex justify-content-between">
                <h4 class="mb-0">Users List</h4>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">+ Add New</a>
            </div>
        </div>
        @if ($data['users']->isEmpty())
            {{-- Logic for no data found --}}
            <div class="alert alert-warning text-center mt-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                Sorry, we couldn't find any matching records.
            </div>
        @else
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered dataTable no-footer" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>S.N.</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($data['users'] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->role_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                         @if ($item->status == 1)
                                         <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">In Active</span>
                                         @endif
                                    </td>
                                    <td name="bstable-actions">
                                        <div class="btn-group pull-right">

                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <span class="fa fa-trash"> </span>
                                                </button>
                                            </form>
                                            <a href="{{ route('user.edit', $item->id) }}">
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <span class="fa fa-edit"> </span>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
@endsection
