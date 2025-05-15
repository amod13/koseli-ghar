@section('content')
    @extends('admin.main.app')
@section('content')

    <div class="row">
        <div class="col-xl-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Add Permission to Role : <span class="text-primary"
                            style="font-size: 30px;font-weight: bold;">{{ $data['getRollName'] }}</span></h5>
                    <a href="{{ route('role.index') }}" class="btn btn-light btn-sm">
                        <i class="fa-solid fa-angles-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.permission.store') }}" method="POST">
                        @csrf
                        <!-- Role Name Display -->
                        <div class="form-group mb-4">
                            <input type="hidden" class="form-control" id="roleId" name="role_id"
                                value="{{ $data['RoleId'] }}">
                        </div>
                        <!-- Permissions Section -->
                        <div class="form-group mb-4">
                            <h6><strong>Give Access to Permissions</strong></h6>
                            <div class="conatiner">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3">
                                            <!-- Select All checkbox -->
                                            <input class="form-check-input" type="checkbox" id="selectAll"
                                                onclick="selectAllPermissions()">
                                            <label class="form-check-label" for="selectAll">Select All</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3 float-end">
                                            <!-- Deselect All checkbox -->
                                            <input class="form-check-input" type="checkbox" id="deselectAll"
                                                onclick="deselectAllPermissions()">
                                            <label class="form-check-label" for="deselectAll">Deselect All
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div id="permissions" class="container">
                                @foreach ($data['permissions'] as $groupname => $permissionGroup)
                                <div class="permission-group mb-4 card">
                                    <div class="row">
                                        <!-- Group Name and Select All Checkbox -->
                                        <div class="col-md-4">
                                            <h5 class="mt-3 py-2 ms-2">{{ $groupname }}</h5>
                                            <div class="form-check ms-2">
                                                <input class="form-check-input select-group" type="checkbox"
                                                    id="selectGroup_{{ \Illuminate\Support\Str::slug($groupname) }}"
                                                    data-group="{{ \Illuminate\Support\Str::slug($groupname) }}">
                                                <label class="form-check-label" for="selectGroup_{{ \Illuminate\Support\Str::slug($groupname) }}">
                                                    Select All in {{ $groupname }}
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Permissions List -->
                                        <div class="col-md-8">
                                            <div class="row">
                                                @foreach ($permissionGroup as $permission)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input group-permission {{ \Illuminate\Support\Str::slug($groupname) }}"
                                                                type="checkbox" name="permission_id[]" value="{{ $permission->id }}"
                                                                id="permission_{{ $permission->id }}"
                                                                @if (in_array($permission->id, $data['roleHasPermissions'])) checked @endif>
                                                            <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 col-lg-12 pt-20 text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Assign Permissions</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
<script>
 document.addEventListener("DOMContentLoaded", function () {
    var selectAllCheckbox = document.getElementById("selectAll");
    var deselectAllCheckbox = document.getElementById("deselectAll");
    var permissionCheckboxes = document.querySelectorAll('input[name="permission_id[]"]');
    var groupCheckboxes = document.querySelectorAll('.select-group');

    function updateSelectAllCheckbox() {
        var allChecked = Array.from(permissionCheckboxes).every(checkbox => checkbox.checked);
        var noneChecked = Array.from(permissionCheckboxes).every(checkbox => !checkbox.checked);

        selectAllCheckbox.checked = allChecked;
        deselectAllCheckbox.checked = noneChecked;
    }

    function updateGroupCheckbox(groupClass) {
        var groupPermissions = document.querySelectorAll(`.${groupClass}`);
        var groupSelectAll = document.getElementById(`selectGroup_${groupClass}`);

        groupSelectAll.checked = Array.from(groupPermissions).every(chk => chk.checked);
        updateSelectAllCheckbox();
    }

    // Handle Group Selection
    groupCheckboxes.forEach(function (groupCheckbox) {
        groupCheckbox.addEventListener("click", function () {
            var groupClass = groupCheckbox.getAttribute("data-group");
            var groupPermissions = document.querySelectorAll(`.${groupClass}`);

            groupPermissions.forEach(checkbox => checkbox.checked = groupCheckbox.checked);

            updateSelectAllCheckbox();
        });
    });

    // Individual permissions update group checkboxes
    permissionCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            var groupClass = Array.from(checkbox.classList).find(cls => cls !== "form-check-input" && cls !== "group-permission");
            updateGroupCheckbox(groupClass);
        });
    });

    // Select All functionality
    selectAllCheckbox.addEventListener("click", function () {
        permissionCheckboxes.forEach(checkbox => checkbox.checked = true);
        groupCheckboxes.forEach(checkbox => checkbox.checked = true);
        deselectAllCheckbox.checked = false;
    });

    // Deselect All functionality
    deselectAllCheckbox.addEventListener("click", function () {
        permissionCheckboxes.forEach(checkbox => checkbox.checked = false);
        groupCheckboxes.forEach(checkbox => checkbox.checked = false);
        selectAllCheckbox.checked = false;
    });

    // Run once on page load in case permissions are pre-checked
    permissionCheckboxes.forEach(checkbox => {
        var groupClass = Array.from(checkbox.classList).find(cls => cls !== "form-check-input" && cls !== "group-permission");
        if (groupClass) updateGroupCheckbox(groupClass);
    });

    updateSelectAllCheckbox();
});

</script>

   <!-- Select All Checkbox Script -->
   <script>
    function selectAllPermissions() {
        var checkboxes = document.querySelectorAll('input[name="permission_id[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
        // Uncheck "Deselect All" if it's checked
        document.getElementById('deselectAll').checked = false;
    }

    function deselectAllPermissions() {
        var checkboxes = document.querySelectorAll('input[name="permission_id[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        // Uncheck "Select All" if it's checked
        document.getElementById('selectAll').checked = false;
    }
</script>

@endpush
