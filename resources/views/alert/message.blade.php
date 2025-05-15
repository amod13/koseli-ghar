{{-- Section Message Start --}}

@if (Session('success') || Session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var deleteModal = new bootstrap.Modal(document.getElementById('SuccessAndError'));
                deleteModal.show();
            }, 2); // Small delay to ensure modal is fully loaded
        });
    </script>
@endif

<div id="SuccessAndError" class="modal fade zoomIn" tabindex="-1" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-md-5">
                <div class="text-center">
                    @if (Session('success'))
                        <div class="text-success">
                            <i class="bi bi-check-circle display-4"></i>
                        </div>
                        <div class="mt-4 fs-15">
                            <h4 class="mb-1">Success!</h4>
                            <p class="text-muted mx-4 mb-0">{{ Session('success') }}</p>
                        </div>
                    @elseif (Session('error'))
                        <div class="text-danger">
                            <i class="bi bi-exclamation-triangle display-4"></i>
                        </div>
                        <div class="mt-4 fs-15">
                            <h4 class="mb-1">Error!</h4>
                            <p class="text-muted mx-4 mb-0">{{ Session('error') }}</p>
                        </div>
                    @endif
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Section Message End --}}
