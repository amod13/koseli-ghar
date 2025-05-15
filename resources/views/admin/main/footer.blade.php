
</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-info btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->



<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this item? This action cannot be undone.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
        </div>
      </div>
    </div>
  </div>





<!-- JAVASCRIPT -->
<script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/plugins.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Vector map-->
<script src="{{ asset('admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

<script src="{{ asset('admin/assets/libs/list.js/list.min.js') }}"></script>

<!--Swiper slider js-->
<script src="{{ asset('admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

<script src="{{ asset('admin/assets/js/backend/product-details.init.js') }}"></script>

{{-- ckeditor --}}
{{-- <script src="{{ asset('admin/assets/js/ckeditor.js') }}"></script> --}}
{{-- Data Table jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!-- DataTable JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- App js -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>


<!-- Select2 JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('#example').DataTable();
  });
</script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    $(document).ready(function() {
        $('.single-select').select2({
            placeholder: "-- Select Category --",
            allowClear: true,
            width: '100%'
        });
    });
</script>

</body>


</html>
