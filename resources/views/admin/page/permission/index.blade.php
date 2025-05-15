@extends('admin.main.app')
@section('content')
@include('alert.message')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permission List</a></li>
                        <li class="breadcrumb-item active">Permission List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- Table List --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title d-flex justify-content-between">
                <h4 class="mb-0">Permission List</h4>
                <a href="{{ route('permission.create') }}" class="btn btn-primary btn-sm">+ Add New</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered dataTable no-footer" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Controller</th>
                            <th>Action Name</th>
                            <th>Group Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        @foreach ($data['permissions'] as $permission => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->controller }}</td>
                                <td>{{ $item->action }}</td>
                                <td>{{ $item->group_name }}</td>
                                <td>
                                    <div class="btn-group pull-right">
                                        <a href="{{ route('permission.edit', $item->id) }}" class="btn btn-sm btn-default">
                                            <span class="fa fa-edit"> </span>
                                        </a>
                                        <form action="{{ route('permission.destroy', $item->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-default">
                                                <span class="fa fa-trash"> </span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
