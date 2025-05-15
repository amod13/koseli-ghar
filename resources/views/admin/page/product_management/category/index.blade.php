@extends('admin.main.app')
@section('content')
    @include('alert.message')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Categories</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categories</a></li>
                        <li class="breadcrumb-item active">
                            {{ isset($data['category']) ? 'Edit Category' : 'Create Category' }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">

        <div class="col-xxl-3">
            {{-- Category Cretae And Edit --}}
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        {{ isset($data['category']) ? 'Edit Category' : 'Create Category' }}
                    </h6>

                    @if (isset($data['category']))
                        <a href="{{ route('category.index') }}" class="btn btn-sm btn-success">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($data['category']) ? route('category.update', $data['category']->id) : route('category.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($data['category']))
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="text" name="name" label="Category Title" :value="old('name', $data['category']->name ?? '')"
                                        id="Name" />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="text" name="slug" label="Slug" :value="old('slug', $data['category']->slug ?? '')"
                                        id="slug" />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="number" name="discount" label="Discount" :value="old('discount', $data['category']->discount ?? '0.00')"
                                        id="discount" />
                                </div>
                            </div>

                            {{-- <div class="col-xxl-12 col-lg-6">
                          <div class="mb-3">
                              <x-form-field type="select"
                                            name="parent_id"
                                            id="parent_id"
                                            label="Select Parent Category"
                                            :options="$data['parentCategories']->pluck('name', 'id')->prepend('Choose Parent Category', '')"
                                            :selected="old('parent_id', $data['category']->parent_id ?? '')" />
                          </div>
                      </div> --}}

                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="select" name="is_featured" id="Is_Featured" label="Is Featured"
                                        :options="['1' => 'Yes', '0' => 'No']" :selected="old('is_featured', $data['category']->is_featured ?? '')" />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="select" name="is_display_home" id="Is_Display_Home" label="Is Display Home"
                                        :options="['0' => 'No','1' => 'Yes']" :selected="old('is_display_home', $data['category']->is_display_home ?? '')" />
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="select" name="is_display_slider" id="Is_Slider" label="Is Slider"
                                        :options="['0' => 'No','1' => 'Yes']" :selected="old('is_display_slider', $data['category']->is_display_slider ?? '')" />
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-6">
                                <div class="mb-3">
                                    <div class="col-xxl-12 col-lg-12">
                                        <div class="mb-3">
                                            <label for="category-image-input" class="form-label d-block">Slider
                                                Image</label>
                                            <div class="position-relative d-inline-block">
                                                <input type="file" name="slider_image" id="SliderImage"
                                                    accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif">

                                                <div class="img-preview mt-2">
                                                    <img id="slider-preview-img" src="" alt="Preview"
                                                        height="50" width="70" style="display: none;">
                                                </div>
                                                @if (isset($data['category']) && $data['category']->slider_image)
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded-3">
                                                            <img src="{{ asset('uploads/images/product/category/slider/' . $data['category']->slider_image ?? '') }}"
                                                                alt="" id="category-img"
                                                                class="avatar-md h-auto rounded-3 object-fit-cover">
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-6">
                                <div class="mb-3">
                                    <x-form-field type="select" name="status" id="Is_Featured" label="Status"
                                        :options="['1' => 'Active', '0' => 'Inactive']" :selected="old('status', $data['category']->status ?? '')" />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-12">
                                <div class="mb-3">
                                    <x-form-field type="textarea" id="descriptionInput" name="description"
                                        label="Description" :value="old('description', $data['category']->description ?? '')" :placeholder="'Enter description'" rows="3" />
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-12">
                                <div class="mb-3">
                                    <label for="category-image-input" class="form-label d-block">Image </label>
                                    <div class="position-relative d-inline-block">

                                        <input type="file" name="image" id="CategoryImage"
                                            accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif">

                                        <div class="img-preview mt-2">
                                            <img id="preview-img" src="" alt="Preview" height="50"
                                                width="70" style="display: none;">
                                        </div>

                                        @if (isset($data['category']) && $data['category']->image)
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-light rounded-3">
                                                    <img src="{{ asset('uploads/images/product/category/' . $data['category']->image ?? '') }}"
                                                        alt="" id="category-img"
                                                        class="avatar-md h-auto rounded-3 object-fit-cover">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-12">
                                <div class="text-end">
                                    <button type="submit"
                                        class="btn btn-success">{{ isset($data['category']) ? 'Update' : 'Submit' }}</button>

                                        <a href="{{ route('category.index') }}"
                                            class="btn btn-danger">{{ isset($data['category']) ? 'Cancel' : 'Cancel' }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div>

        <div class="col-xxl-9">

            {{-- category search --}}
            <div class="row justify-content-between mb-4 card">
                <div class="col-xxl-12 col-lg-12 card-body">
                    <form action="{{ route('category.search') }}" method="GET" class="mb-3">
                        <div class="input-group mb-3 mb-lg-0">
                            <input type="text" name="search" class="form-control" id="searchInputList"
                                placeholder="Search Category by name..." value="{{ request()->get('search') }}">
                            <button type="submit" class="btn btn-success">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- category list --}}
            <div class="card">
                <div class="card-body row">
                    @foreach ($data['categories'] as $item)
                        <div class="col-xxl-4 col-md-6">
                            <div class="card categrory-widgets overflow-hidden">
                                <div class="card-body p-4 d-flex">
                                    <!-- Image on the left -->
                                    @if ($item->image == null)
                                    <div class="me-3 card" style="width: 80px; height: 80px;">
                                        <img src="{{ asset('uploads/images/site/' . ($data['setting']->default_image ?? '')) }}"
                                            alt="{{ $item->name }}"
                                            class="img-fluid h-100 w-100 object-fit-cover rounded-3">
                                    </div>
                                    @else
                                    <div class="me-3 card" style="width: 80px; height: 80px;">
                                        <img src="{{ asset('uploads/images/product/category/' . ($item->image ?? '')) }}"
                                            alt="{{ $item->name }}"
                                            class="img-fluid h-100 w-100 object-fit-cover rounded-3">
                                    </div>
                                    @endif


                                    <!-- Category Content -->
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="flex-grow-1 mb-0">{{ $item->name }}</h5>
                                            <ul class="flex-shrink-0 list-unstyled hstack gap-1 mb-0">
                                                <li><a href="{{ route('category.edit', $item->id) }}"
                                                        class="badge bg-info-subtle text-info">Edit</a></li>
                                                <li>
                                                    <form action="{{ route('category.destroy', $item->id) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-default badge bg-danger-subtle text-danger delete-button"
                                                            onclick="confirmDelete(event)">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-3">
                                            <a data-bs-toggle="offcanvas" href="#viewCategory"
                                                class="fw-medium link-effect overview-btn"
                                                data-view-id="{{ $item->id }}">Read More <i
                                                    class="ri-arrow-right-line align-bottom ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="vs-pagination pt-lg-2">
                        {{ $data['categories']->links('pagination::bootstrap-5') }}
                    </div>

                    @if ($data['categories']->isEmpty())
                        <span>No Data Found</span>
                    @endif
                </div>
            </div>

        </div>

    </div>
    <!--end row-->


    {{-- Category Detail --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="viewCategory" aria-labelledby="overviewOffcanvasLabel">
        <div class="offcanvas-header bg-primary-subtle">
            <h5 class="offcanvas-title" id="overviewOffcanvasLabel">#Detail<span class="overview-id"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Category Image Preview
        document.getElementById('CategoryImage').addEventListener('change', function(event) {
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

        // Slider Image Preview
        document.getElementById('SliderImage').addEventListener('change', function(event) {
            const input = event.target;
            const previewImg = document.getElementById('slider-preview-img');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        })
    </script>

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
            let formToSubmit = null;
            // When delete button is clicked
            $(document).on("click", ".delete-button", function(event) {
                event.preventDefault();
                formToSubmit = $(this).closest("form");

                // Optionally change modal content dynamically here if needed
                let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            });

            // When confirm delete is clicked
            $(document).on("click", "#confirmDelete", function() {
                if (formToSubmit) {
                    formToSubmit.submit();
                    formToSubmit = null;
                }
            });


            // overViewList
            function viewCategory() {
                var getViewid = 0;
                // Loop through all elements with the "overview-btn" class
                $(".overview-btn").each(function() {
                    $(this).on('click', function() {
                        debugger;
                        // Get the category ID from the data-view-id attribute
                        categoryId = $(this).data(
                            'view-id'); // Fixed the attribute to 'data-view-id'
                        url = "{{ route('category.show', ':id') }}".replace(':id', categoryId);
                        // Make an AJAX request to fetch the category details
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                $('#viewCategory').find('.offcanvas-body').html(response
                                    .html);
                            },
                            error: function() {
                                alert('Error loading category details.');
                            }
                        });
                    });
                });
            }

            // Call the function after the page loads
            $(document).ready(function() {
                viewCategory(); // Initialize the event listeners
            });

            // Search text remove to reload page
            $('input[name="search"]').on('input', function() {
                if ($.trim($(this).val()) === "") {
                    window.location.href =
                        "{{ route('category.index') }}"; // Redirect to category list page
                }
            });
        });
    </script>
@endpush
