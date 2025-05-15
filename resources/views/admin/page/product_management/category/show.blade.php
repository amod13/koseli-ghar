<div class="avatar-lg mx-auto">
    <div class="avatar-title bg-light rounded">
        <img src="{{ asset('uploads/images/product/category/'. $data['category']->image) }}" alt="" class="avatar-sm overview-img">
    </div>
</div>
<div class="text-center mt-3">
    <h5 class="overview-title">{{ $data['category']->name }}</h5>
    <p class="text-muted">by <a href="#!" class="text-reset">Admin</a></p>
</div>

<h6 class="fs-14">Description</h6>
<p class="text-muted overview-desc">
    {{ $data['category']->description }}
</p>

<div class="p-3 border-top">
    <div class="row">
        <div class="col-sm-6">
            <a href="{{ route('category.edit',$data['category']->id) }}"  class="btn btn-secondary w-100 edit-list"><i class="ri-pencil-line me-1 align-bottom"></i> Edit</a>
        </div>
    </div>
</div>
