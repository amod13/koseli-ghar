@extends('admin.main.app')
@section('content')
    @include('alert.message')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
                    <li class="breadcrumb-item active">create</li>
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
        action="{{ route('product.store') }}" enctype="multipart/form-data">
        @csrf
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
                                <x-form-field type="text" name="name" label="Product Name" :value="old('name')"
                                    id="Name" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <x-form-field type="text" name="slug" label="Slug" :value="old('slug')"
                                    id="Slug" />
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="Description">Description</label>
                                <textarea name="description" id="editor" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group mb-3">
                                <x-form-field type="select" name="category_id" id="category_id" label="Select Category"
                                    :options="$data['categories']
                                        ->pluck('name', 'id')
                                        ->prepend('--- Select Category ---', '')" :selected="old('category_id')" />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-group mb-3">
                                <label for="brand_id" class="form-label">Select Brand</label>
                                <select class="form-select single-select" name="brand_id" id="brand_id">
                                    <option selected disabled>--- Select Brand ---</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12">
                            <div class="mb-3">
                                <x-form-field type="text" name="sku" label="Sku" :value="old('sku')"
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
                                    <x-form-field type="number" name="stock" label="Stocks" :value="old('stock')"
                                        id="Stocks" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="mb-3">
                                    <div class="input-group has-validation mb-3">
                                        <x-form-field type="number" name="price" label="Price" :value="old('price')"
                                            id="Price" />
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div>
                </div>


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
                                <h5 class="card-title mb-1">Gallery Images</h5>
                                <p class="text-muted mb-0">Add Other Inages.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row appended-filetype-row">

                            <div class="col-md-8">
                                <x-form-field type="file" name="gallery_image[]" label="Image " />
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Action</label>
                                <div class="input-group">
                                    <span class="input-group-text add-filetype-row">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                            </div>
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
                                :options="['1' => 'Active', '0' => 'Inactive']" :selected="old('status')" />
                        </div>

                        <div>
                            <x-form-field type="select" name="is_featured" id="visibilityStatus"
                                label="Choose Visibility" :options="['1' => 'Public', '0' => 'Draft']" :selected="old('is_featured')" />
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
                                <img id="preview-img" src="" alt="Preview" height="50"
                                    width="70" style="display: none;">
                            </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Meta Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-form-field type="text" name="meta_description" label="Meta Description" :value="old('meta_description')"
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
        // Add new image upload row
           $(document).on('click', '.add-filetype-row', function () {
                debugger;
                $.ajax({
                    url: '{{ route('product.file.row') }}',
                    method: 'GET',
                    success: function (response) {
                        $('.appended-filetype-row').last().after(response.html);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error loading partial view:', error, xhr.responseText);
                    }
                });
            });

               // Remove row
               $(document).on('click', '.remove-filetype-row', function () {
                let row = $(this).closest('.row'); // Assuming each key-value pair is wrapped in a .row div

                if (row.length === 0) {
                    console.error("Could not find the appended row.");
                    return;
                }

                // Check for a delete-flag input
                let deleteFlag = row.find('.delete-flag');
                if (deleteFlag.length > 0) {
                    deleteFlag.val(1); // Mark as deleted
                    row.hide(); // Hide the row
                } else {
                    row.remove(); // Completely remove the row
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
