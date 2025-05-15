@extends('admin.main.app')
@section('content')
    @include('alert.message')


    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Brands</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- Table List --}}
    <div class="row align-items-center mb-4">
        <div class="col-xxl-12 col-lg-12 col-sm-12 card">

            <form action="{{ route('brand.search') }}" method="GET" class="row g-3 align-items-end mb-4 card-body">

                {{-- Category Select --}}
                <div class="col-md-4">
                    <x-form-field type="select" name="category" id="category_id" label="Select Category" :options="$data['categories']->pluck('name', 'id')->prepend('--- Select Category ---', '')"
                        :selected="request()->get('category')" />
                </div>

                {{-- Search Input --}}
                <div class="col-md-4">
                    <label for="searchInputList" class="form-label">Brand Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchInputList" autocomplete="off"
                            placeholder="Search by name..." name="search" value="{{ request()->get('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success">
                        Search
                    </button>

                    <a href="{{ route('brand.index') }}" class="btn btn-danger">
                        Cancel
                    </a>
                    </a>
                </div>

            </form>
        </div>
        <div class="col-xxl-3 col-lg-8 col-sm-9">
            {{-- customizeation add here --}}
        </div>
        <div class="col-lg-auto ms-auto col-sm-3">
            <button data-bs-target="#createModal" data-bs-toggle="modal" class="btn btn-success w-100"><i
                    class="bi bi-plus-circle me-1 align-middle"></i> Add Brand</button>
        </div>
    </div>

    <div class="row row-cols-xxl-5 row-cols-lg-4 row-cols-sm-2 row-cols-1" id="brand-list">
        @foreach ($data['brands'] as $item)
            <div class="col">
                <div class="card brand-widget card-animate">
                    <div class="card-body text-center pb-2">
                        <div class="d-flex align-items-center mb-3">
                            <h5 class="flex-grow-1 mb-0">{{ $item->name }}</h5>
                            <ul class="flex-shrink-0 list-unstyled hstack gap-1 mb-0">
                                <li>
                                    <a href="javascript:void(0);" class="badge bg-info-subtle text-info editBrand"
                                        data-view-id="{{ $item->id }}">
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('brand.destroy', $item->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="btn btn-sm btn-default badge bg-danger-subtle text-danger delete-button">
                                            Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @if ($item->image == null)
                            <img src="{{ asset('uploads/images/site/' . $data['setting']->default_image) }}"
                                alt="{{ $item->name }}" class="brand-img">
                        @else
                            <img src="{{ asset('uploads/images/product/brand/' . $item->image) }}"
                                alt="{{ $item->name }}" class="brand-img">
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    @if ($data['brands']->isEmpty())
        <div id="noresult">
            <div class="text-center py-4">
                <div class="avatar-md mx-auto mb-4">
                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-24">
                        <i class="bi bi-search"></i>
                    </div>
                </div>
                <h5 class="mt-2">Sorry! No Brand Found</h5>
            </div>
        </div>
    @else
    @endif

    {{-- pagination Start --}}
    <div class="vs-pagination pt-lg-2">
        {{ $data['brands']->links('pagination::bootstrap-5') }}
    </div>
    {{-- pagination End --}}


    <!-- createModal or Brand -->
    <div id="createModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header px-4 pt-4">
                    <h5 class="modal-title fs-18">Create brand profile</h5>
                    <button type="button" class="btn-close" id="createModal-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form autocomplete="off" novalidate class="create-form" enctype="multipart/form-data"
                        action="{{ route('brand.store') }}" method="POST">
                        @csrf
                        <div id="alert-error-msg" class="d-none alert alert-danger py-2"></div>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="multiSelectDropdown" class="form-label">Select Categories</label>
                                    <div class="dropdown">
                                        <button class="form-control text-start" type="button" id="multiSelectDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Choose Categories
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="multiSelectDropdown">
                                            @foreach($data['categories'] as $category)
                                            <li>
                                                <div class="form-check ms-2">
                                                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                                           {{ in_array($category->id, old('category_id', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="cat_{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <x-form-field type="text" name="name" label="Brand Name" :value="old('name')"
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
                                    <label for="brandLogo" class="form-label">Brand Logo</label>
                                    <input class="form-control" id="brandLogo" type="file" name="image"
                                        accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif">
                                    <div class="img-preview mt-2">
                                        <img id="preview-img" src="" alt="Preview" height="50"
                                            width="70" style="display: none;">
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <x-form-field type="select" name="status" id="activeStatus" label="Choose Status"
                                        :options="['1' => 'Active', '0' => 'Inactive']" :selected="old('status')" />
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                                            class="ri-close-line align-bottom me-1"></i> Close</button>
                                    <button type="submit" class="btn btn-primary">Add Brand</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- EditModal --}}
    <div id="editModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header px-4 pt-4">
                    <h5 class="modal-title fs-18">Edit brand profile</h5>
                    <button type="button" class="btn-close" id="createModal-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 edit-form">

                </div>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let createModal = new bootstrap.Modal(document.getElementById('createModal'));
                createModal.show();
            });
        </script>
    @endif

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


            // Edit Brand Modal
            $(document).on('click', '.editBrand', function() {
                debugger;
                let brandId = $(this).data('view-id');
                let url = "{{ route('brand.edit', ':id') }}".replace(':id', brandId);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        debugger;
                        console.log(response);
                        // Open the modal
                        $("#editModal").modal("show");
                        $('#editModal').find('.edit-form').html(response.html);
                    },
                    error: function() {
                        alert('Error loading brand details.');
                    }
                });
            });


            // // Delete Confirmation message
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

            // Search text remove to reload page
            $('input[name="search"]').on('input', function() {
                if ($.trim($(this).val()) === "") {
                    window.location.href = "{{ route('brand.index') }}"; // Redirect to category list page
                }
            });

            document.addEventListener('click', function() {
                const input = document.getElementById('brandLogo');
                const previewImg = document.getElementById('preview-img');

                if (input && previewImg) {
                    input.addEventListener('change', function(event) {
                        if (event.target.files && event.target.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                previewImg.src = e.target.result;
                                previewImg.style.display = 'block';
                            };

                            reader.readAsDataURL(event.target.files[0]);
                        }
                    }, {
                        once: true
                    }); // ensures it doesn't attach multiple times
                }
            });


        });
    </script>





@endpush
