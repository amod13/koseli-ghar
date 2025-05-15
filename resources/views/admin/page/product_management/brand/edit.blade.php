<form autocomplete="off" novalidate class="create-form" enctype="multipart/form-data"
    action="{{ route('brand.update', $data['brand']->id) }}" method="POST">
    @csrf
    @method('PUT')
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
                                       {{ in_array($category->id, old('category_id',$data['brand']->category_id ?? [])) ? 'checked' : '' }}>
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
                <x-form-field type="text" name="name" label="Brand Name" :value="old('name', $data['brand']->name)" id="Name" />
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mb-3">
                <x-form-field type="text" name="slug" label="Slug" :value="old('slug', $data['brand']->slug)" id="Slug" />
            </div>
        </div>


        <div class="col-lg-12">
            <div class="mb-3">
                <x-form-field type="file" name="image" label="Image" id="brandLogo" />
                <img src="{{ asset('uploads/images/product/brand/' . $data['brand']->image) }}"
                    alt="{{ $data['brand']->name }}" height="50" accept="image/png, image/gif, image/jpeg, image/jpg, image/webp, image/avif">
                <div class="img-preview mt-2">
                    <img id="preview-img" src="" alt="Preview" height="50" width="70"
                        style="display: none;">
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="mb-3">
                <x-form-field type="select" name="status" id="activeStatus" label="Choose Status" :options="['1' => 'Active', '0' => 'Inactive']"
                    :selected="old('status', $data['brand']->status)" />
            </div>
        </div>

        <div class="col-lg-12">
            <div class="hstack gap-2 justify-content-end">
                <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                        class="ri-close-line align-bottom me-1"></i> Close</button>
                <button type="submit" class="btn btn-primary">Update Brand</button>
            </div>
        </div>

    </div>
</form>

