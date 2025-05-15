@extends('admin.main.app')
@section('content')
    @include('alert.message')

    {{-- Search Filter --}}
    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-15 w-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">Product Search Filter</h5>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-lg-12">
                        <div class="card radius-15 border shadow-none mb-0">
                            <div class="card-body">
                                <form action="{{ route('product.search') }}" method="GET">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="category_id" class="form-label">Select Category</label>
                                                <select class="form-select single-select form-control" name="category_id"
                                                    id="category_id">
                                                    <option selected disabled>--- Select Category ---</option>
                                                    @foreach ($data['categories'] as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ old('category_id', $data['selected_category_id'] ?? '') == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="brand_id" class="form-label">Select Brand</label>
                                                <select class="form-select single-select" name="brand_id" id="brand_id">
                                                    <option selected disabled>--- Select Brand ---</option>
                                                </select>
                                                <input type="hidden" name="selected_brand_id"
                                                    value="{{ old('brand_id', $data['selected_brand_id'] ?? '') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="Status" class="form-label">Select Status</label>
                                                <select class="form-select single-select" name="status" id="Status">
                                                    <option selected disabled>--- Select Status ---</option>
                                                    <option value="1"
                                                        {{ old('status', $data['selected_status'] ?? '') == 1 ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ old('status', $data['selected_status'] ?? '') == 0 ? 'selected' : '' }}>
                                                        InActive</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="IsFeatured" class="form-label">Is Featured</label>
                                                <select class="form-select single-select" name="is_featured"
                                                    id="IsFeatured">
                                                    <option selected disabled>--- Select Status ---</option>
                                                    <option value="1"
                                                        {{ old('is_featured', $data['selected_is_featured'] ?? '') == 1 ? 'selected' : '' }}>
                                                        Public</option>
                                                    <option value="0"
                                                        {{ old('is_featured', $data['selected_is_featured'] ?? '') == 0 ? 'selected' : '' }}>
                                                        Draft</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="Search By Name" class="form-label">Search By Name</label>
                                                    <input type="Product Name" class="form-control" name="keyword"
                                                        placeholder="search by name.."
                                                        value="{{ $data['selected_keyword'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="mb-3" style="margin-top:33px;">
                                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                <a href="{{ route('product.index') }}"
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
    {{-- End Search Filter --}}
    @if ($data['products']->isEmpty())
        <div class="card">
            <div class="card-header">
                <div class="card-title d-flex justify-content-between">
                    <h4 class="mb-0">Product List</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">+ Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="no__data_found py-5">
                    <div class="text-center">
                        <h5 class="text-muted">Use Search Filter to Find Products!</h5>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- Table List --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title d-flex justify-content-between">
                    <h4 class="mb-0">Product List</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">+ Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="exampleOne" class="table table-striped table-bordered dataTable no-footer" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>S.N.</th>
                                <th>Name</th>
                                <th>Category Name</th>
                                <th>Brand Name</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($data['products'] as $product => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category_name }}</td>
                                    <td>{{ $item->brand_name }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <a href="{{ route('product.edit', $item->id) }}"
                                                class="btn btn-sm btn-default">
                                                <span class="fa fa-edit"> </span>
                                            </a>
                                            <form action="{{ route('product.destroy', $item->id) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-default">
                                                    <span class="fa fa-trash"> </span>
                                                </button>
                                            </form>

                                            <a href="{{ route('product.show', $item->id) }}"
                                                class="btn btn-sm btn-default">
                                                <span class="fa fa-eye"></span>
                                            </a>

                                            <a href="{{ route('product.image', $item->id) }}"
                                                class="btn btn-sm btn-default">
                                                <span class="fa fa-image"></span>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-xxl-12 justify-content-center">
                            {{ $data['products']->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var selectedCategoryId = $('#category_id').val();
            if (selectedCategoryId) {
                loadBrands(selectedCategoryId);
            }

            $('#category_id').change(function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    loadBrands(categoryId);
                }
            });

            function loadBrands(categoryId) {
                $.ajax({
                    url: '{{ route('category.brand.search', ['category_id' => ':id']) }}'.replace(':id',
                        categoryId),
                    type: 'GET',
                    success: function(response) {
                        var brandSelect = $('#brand_id');
                        brandSelect.empty();
                        brandSelect.append('<option selected disabled>--- Select Brand ---</option>');

                        $.each(response, function(index, brand) {
                            brandSelect.append($('<option>').text(brand.name).val(brand.id));
                        });

                        var selectedBrandId = $('input[name="selected_brand_id"]').val();
                        if (selectedBrandId) {
                            brandSelect.val(selectedBrandId);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endpush
