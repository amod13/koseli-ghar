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


    <div class="row gx-lg-4">

        <div class="col-xl-4 col-lg-8 mx-auto">
            <div class="row sticky-side-div">
                <div class="col-lg-12">
                    <div class="alert alert-success text-center">
                        Product Images
                    </div>
                </div>

                <div class="col-lg-2">
                    <div thumbsSlider class="swiper productSwiper productswiper-2 mb-3 mb-lg-0">
                        <div class="swiper-wrapper product-wrapper">
                            @foreach($data['product']->product_files as $file)
                                <div class="swiper-slide">
                                    <div class="product-thumb rounded cursor-pointer">
                                        <img src="{{ asset('uploads/images/product/gallery/' . $file->gallery_image) }}" alt="Product Image" class="img-fluid">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="bg-light rounded-2 position-relative ribbon-box overflow-hidden">
                        <div class="swiper productSwiper2">
                            <div class="swiper-wrapper">
                                @foreach($data['product']->product_files as $file)

                                    <div class="swiper-slide">
                                        <img src="{{ asset('uploads/images/product/gallery/' . $file->gallery_image) }}" alt="Product Image" class="img-fluid">
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next bg-transparent"></div>
                            <div class="swiper-button-prev bg-transparent"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-xl-8">
            <div class="mt-5 mt-xl-0">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h4>{{ $data['product']->name }}</h4>
                        <div class="hstack gap-3 flex-wrap">
                            <div><a href="#" class="text-primary d-block">{{ $data['product']->category_name }}</a></div>
                            <div class="vr"></div>
                            <div class="text-muted">Category Name : <span class="text-body fw-medium">{{ $data['product']->category_name }}</span></div>
                            <div class="vr"></div>
                            <div class="text-muted">Brand : <span class="text-body fw-medium">{{ $data['product']->brand_name }}</span></div>
                            <div class="vr"></div>
                            <div class="text-muted">Published : <span class="text-body fw-medium">{{ $data['product']->created_at }}</span></div>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('product.edit', $data['product']->id) }}" class="btn btn-soft-secondary btn-icon"><i class="ri-pencil-fill align-bottom"></i></a>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-2 align-items-center mt-3">
                    <div class="text-muted fs-16">
                        <span class="mdi mdi-star text-warning"></span>
                        <span class="mdi mdi-star text-warning"></span>
                        <span class="mdi mdi-star text-warning"></span>
                        <span class="mdi mdi-star text-warning"></span>
                        <span class="mdi mdi-star text-warning"></span>
                    </div>
                    <div class="text-muted">( {{ $data['product']->review_count }} Review )</div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-4 col-sm-6 g-3">
                        <div class="p-2 border border-dashed rounded text-center">
                            <p class="mb-2 text-uppercase text-muted fs-13">Price :</p>
                            <h5 class="mb-0">Rs. {{ $data['product']->price }}</h5>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 g-3">
                        <div class="p-2 border border-dashed rounded text-center">
                            <p class="mb-2 text-uppercase text-muted fs-13">Stock :</p>
                            <h5 class="mb-0">{{ $data['product']->stock }}</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 g-3">
                        <div class="p-2 border border-dashed rounded text-center">
                            <p class="mb-2 text-uppercase text-muted fs-13">Status :</p>
                            <h5 class="mb-0">
                                @if ($data['product']->status == 1)
                                    <span class="badge badge-soft-success">Active</span>
                                    @else
                                    <span class="badge badge-soft-danger">Inactive</span>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>


                <div class="mt-4 text-muted">
                    <h5 class="fs-15">Description :</h5>
                    <p>
                        {!! $data['product']->description !!}
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection
