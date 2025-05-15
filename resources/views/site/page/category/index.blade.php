@extends('site.main.app')
@section('content')
@include('alert.sitemessage')

    {{-- categories area start --}}
    <section class="deal__area pb-45 pt-25 grey-bg ">
        <div class="container">
            <div class="row">
                <div class="section__head d-md-flex justify-content-between mb-40">
                    <div class="section__title">
                        <h3>Categories</h3>
                    </div>
                </div>
                <div class="row">
                    @foreach ($data['categories'] as $item)
                        <div class="col-md-4 col-lg-3 col-xl-2 col-4">
                            <div class="product__item white-bg mb-30">
                                <div class="product__thumb p-relative category__list">
                                    <a href="{{ route('category.slug', $item->slug ?? '') }}" class="w-img">
                                        <img loading="lazy"
                                            src="{{ asset('uploads/images/product/category/' . $item->image) }}"
                                            alt="{{ $item->name ?? 'No Image' }}">
                                    </a>
                                </div>
                                <div class="product__content text-center">
                                    <h6 class="product-name">
                                        <a class="product-item-link"
                                            href="{{ route('category.slug', $item->slug ?? '') }}">{{ $item->name }}</a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </section>
    {{-- categories area end --}}


@endsection
