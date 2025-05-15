@extends('admin.main.app')
@section('content')
    @include('alert.message')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                    <li class="breadcrumb-item active">edit</li>
                </ol>

                <div class="page-title-right">
                    <a href="{{ route('product.index') }}">
                        <span class="back d-flex" style="flex-direction: row-reverse">
                            <span class="btn btn-light m-1 px-5" style="font-size:13px;">
                                <i class="fa-solid fa-angles-left"></i>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <form id="createproduct-form" autocomplete="off" class="needs-validation" method="POST"
        action="{{ route('product.update', $data['product']->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-xl-9 col-lg-8">
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
                                <h5 class="card-title mb-1">Product Information</h5>
                                <p class="text-muted mb-0">Fill all information below.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body row">

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <x-form-field type="text" name="name" label="Product Name" :value="old('name', $data['product']->name)"
                                    id="Name" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <x-form-field type="text" name="slug" label="Slug" :value="old('slug', $data['product']->slug)"
                                    id="Slug" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <div>
                                <textarea name="description" class="form-control" placeholder="Enter product description" id="editor"
                                    :value="old('description')" label="Description">{{ old('description', $data['product']->description) }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group mb-3">
                                <x-form-field type="select" name="category_id" id="category_id" label="Select Category"
                                    :options="$data['categories']
                                        ->pluck('name', 'id')
                                        ->prepend('--- Select Category ---', '')" :selected="old('category_id', $data['product']->category_id)" />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group mb-3">
                                <x-form-field type="select" name="brand_id" id="brand_id" label="Select Brand"
                                    :options="[]" />
                                <input type="hidden" id="selected_brand_id"
                                    value="{{ old('brand_id', $data['product']->brand_id) }}">
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12">
                            <div class="mb-3">
                                <x-form-field type="text" name="sku" label="Sku" :value="old('sku', $data['product']->sku)"
                                    id="Sku" />
                            </div>
                        </div>


                    </div>
                </div>
                <!-- end card -->

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title rounded-circle bg-light text-primary fs-20">
                                        <i class="bi bi-list-ul"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1">General Information</h5>
                                <p class="text-muted mb-0">Fill all information below.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <x-form-field type="number" name="stock" label="Stocks" :value="old('stock', $data['product']->stock)"
                                        id="Stocks" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <div class="input-group has-validation mb-3">
                                        <x-form-field type="number" name="price" label="Price" :value="old('price', $data['product']->price)"
                                            id="Price" />
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->


                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col-xl-3 col-lg-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Publish</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <x-form-field type="select" name="status" id="activeStatus" label="Choose Status"
                                :options="['1' => 'Active', '0' => 'Inactive']" :selected="old('status', $data['product']->status)" />
                        </div>

                        <div>
                            <x-form-field type="select" name="is_featured" id="visibilityStatus"
                                label="Choose Visibility" :options="['1' => 'Public', '0' => 'Draft']" :selected="old('is_featured', $data['product']->is_featured)" />
                        </div>

                    </div>
                </div>

                <div class="col-xxl-12 col-lg-12 card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thumbnail Image</h5>
                    </div>
                    <div class="mb-3 card-body">
                        <label for="category-image-input" class="form-label d-block">Thumbnail Image <span
                                class="text-danger">*</span></label>
                        <input class="form-control" id="ProductImage" type="file"
                            accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif" name="image">

                        <div class="img-preview mt-2">
                            <img id="preview-img" src="" alt="Preview" height="50" width="70"
                                style="display: none;">
                        </div>
                        <div class="avatar-lg">
                            <div class="avatar-title bg-light rounded-3">
                                <img src="{{ asset('uploads/images/product/thumbnailImage/' . $data['product']->image) }}"
                                    alt="{{ $data['product']->name }}" id="brandLogo-img"
                                    class="avatar-md h-auto rounded-3 object-fit-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Meta Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-form-field type="text" name="meta_description" label="Meta Description" :value="old('meta_description', $data['product']->meta_description)"
                            id="Meta Description" />
                        </div>
                    </div>
                </div>

            </div>
            <!-- end col -->
            <!-- end card -->
            <div class="text-end mb-3">
                <button type="submit" class="btn btn-success w-sm">Submit</button>
            </div>
        </div>
        <!-- end row -->
    </form>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            const titleInput = $('input[name="name"]'); // Title field
            const slugInput = $('input[name="slug"]'); // Slug field

            function generateSlug(text) {
                let uuid = crypto.randomUUID(); // Generate a unique UUID
                let formattedSlug = text
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-') // Replace spaces & special chars with "-"
                    .replace(/^-+|-+$/g, ''); // Remove leading & trailing "-"

                return `${formattedSlug}-${uuid}`; // Format slug
            }

            titleInput.on("input", function() {
                let titleValue = $.trim($(this).val());
                slugInput.val(titleValue !== "" ? generateSlug(titleValue) : "");
            });


            // Delete Confirmation message
            $(document).on("click", ".delete-button", function(event) {
                event.preventDefault(); // Prevent default form submission

                if (confirm("Are you sure you want to delete this?")) {
                    $(this).closest("form").submit(); // Submit the closest form
                }
            });


        });
    </script>

    <script>
        //   Image Preview
        document.getElementById('ProductImage').addEventListener('change', function(event) {
            const input = event.target;
            const previewImg = document.getElementById('preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
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

                        var selectedBrandId = $('#selected_brand_id').val();

                        $.each(response, function(index, brand) {
                            var option = $('<option>').text(brand.name).val(brand.id);
                            if (selectedBrandId == brand.id) {
                                option.prop('selected', true);
                            }
                            brandSelect.append(option);
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    </script>
@endpush
