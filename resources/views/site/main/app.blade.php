<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="light"
    data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-body-image="none">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}{{ isset($data['header_title']) ? ' - ' . $data['header_title'] : '' }}</title>
    <meta name="description" content="{{ $data['setting']->meta_description ?? ($data['product']->meta_description ?? '') . ' | ' . ($data['setting']->site_name ?? '') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Basic SEO -->
    <meta name="description" content="{{ $data['product']->description ?? '' }} | {{ $data['setting']->site_name ?? '' }}" />
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />

    <!-- Open Graph (Facebook, LinkedIn, etc.) -->
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $data['product']->name ?? '' }} | {{ $data['setting']->site_name ?? '' }}" />
    <meta property="og:description" content="{{ $data['product']->description ?? '' }} – available now at {{ $data['setting']->site_name ?? '' }}." />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ $data['setting']->site_name ?? '' }}" />
    <meta property="og:image" content="{{ !empty($data['product']->image) ? asset('uploads/images/product/thumbnailImage/' . $data['product']->image) : asset('uploads/images/site/' . $data['setting']->logo) }}" />

    <meta property="article:publisher" content="{{ $data['setting']->facebook ?? '' }}" />
    <meta property="article:modified_time" content="{{ $data['product']->updated_at ?? '' }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $data['product']->name ?? '' }} | {{ $data['setting']->site_name ?? '' }}" />
    <meta name="twitter:description" content="{{ $data['product']->description ?? '' }} – available now at {{ $data['setting']->site_name ?? '' }}." />
    <meta name="twitter:image" content="{{ !empty($data['product']->image) ? asset('uploads/images/product/thumbnailImage/' . $data['product']->image) : asset('uploads/images/site/' . $data['setting']->logo) }}" />
    <meta name="twitter:label1" content="Est. reading time" />
    <meta name="twitter:data1" content="2 minutes" />

    <script type="application/ld+json">
        {
            "@type": "Product",
            "name": "{{ $data['product']->name ?? '' }}",
            "image": "{{ !empty($data['product']->image) ? asset('uploads/images/product/thumbnailImage/' . $data['product']->image) : asset('uploads/images/site/' . $data['setting']->logo) }}",
            "description": "{{ $data['product']->description ?? '' }}",
            "sku": "{{ $data['product']->sku ?? '' }}",
            "url": "{{ url()->current() }}",
            "brand": {
              "@type": "Brand",
              "name": "{{ $data['product']->brand->name ?? 'Generic' }}"
            },
            "offers": {
              "@type": "Offer",
              "priceCurrency": "NPR",
              "price": "{{ $data['product']->price ?? 0 }}",
              "availability": "https://schema.org/InStock"
            }

        }
    </script>


    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/images/site/' . $data['setting']->favicon) }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('site/assets/css/preloader.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/backToTop.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/fontAwesome5Pro.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/ui-range-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/style.css') }}">

    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Icon For Chat Box  -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
</head>

<body>
    @include('site.main.head')
    @yield('content')
    @include('site.main.footer')
    @stack('scripts')
</body>

</html>
