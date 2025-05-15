@extends('admin.main.app')
@section('content')
@include('alert.message')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center mb-3">
                <label class="me-2 fw-semibold fs-5 text-muted">Product Name:</label>
                <h2 class="mb-0 text-dark">{{ $data['productName'] }}</h2>
            </div>

            <div class="col-md-6">
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
    <div class="card-body">
        <div class="p-4 border rounded">
            <div class="row">
                <div class="col-12 col-lg-12 border-right">
                    <form class="row g-3" action="{{ route('product.file.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Display existing images -->
                            @foreach ( $data['images'] as $image)
                                <div class="col-md-4 text-center mb-4" id="image-row-{{ $image->id }}">
                                    <img src="{{ asset('uploads/images/product/gallery/' . $image->gallery_image) }}"
                                         alt="Image" class="img-thumbnail" style="width: 100%; height: 250px;">

                                    <!-- Edit (replace) image -->
                                    <div class="mt-2">
                                        <input type="file" name="update_images[{{ $image->id }}]" class="form-control form-control-sm" accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif">
                                    </div>

                                    <!-- Delete button -->
                                    <button type="button" class="btn btn-danger btn-sm mt-2 delete-image-btn"
                                            data-id="{{ $image->id }}">Remove</button>

                                </div>
                            @endforeach
                        </div>

                        <!-- Add new images -->
                        <div class="row appended-filetype-row">
                            <div class="col-md-8">
                                <x-form-field type="file" name="gallery_image[]" label="Image " />
                            </div>

                            <input type="hidden" name="product_id" value="{{ $data['productId'] }}">

                            <div class="col-md-4">
                                <label class="form-label">Action</label>
                                <div class="input-group">
                                    <span class="input-group-text add-filetype-row">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 button_submit">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
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

            // Delete image
            $(document).on('click', '.delete-image-btn', function () {
                debugger;
                let imageId = $(this).data('id'); // Get the image ID from the button
                let url = '{{ route("product.file.delete", ":id") }}'.replace(':id', imageId); // Replace placeholder with actual image ID

                if (confirm('Are you sure you want to delete this image?')) {
                    $.ajax({
                        url: url, // Send the DELETE request to the generated URL
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: imageId
                        },
                        success: function (response) {
                            debugger;
                            if (response.success) {
                                $('#image-row-' + imageId).remove(); // Remove the row for the deleted image
                                alert(response.message); // Display a success message
                            } else {
                                alert('Failed to delete the image.'); // Handle unexpected failure
                            }
                        },
                        error: function (xhr, status, error) {
                            debugger;
                            console.error('Error deleting image:', error, xhr.responseText); // Log the error details
                            alert('An error occurred while deleting the image. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
