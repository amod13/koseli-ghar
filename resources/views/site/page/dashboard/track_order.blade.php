@extends('site.main.app')

@section('content')
    @include('alert.sitemessage')

    <main class="bg-light py-5">
        <div class="container">

            <!-- Page Header -->

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                @auth
                    <a href="{{ route('site.user.profile', $data['userId']) }}" class="t-y-btn">
                        <i class="bi bi-arrow-left me-1"></i> Back to Profile
                    </a>
                @endauth
            </div>

            <!-- Form Start -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="bg-white p-5 rounded shadow text-center">
                        <h3 class="mb-4 text-primary fw-bold">Track Your Order</h3>
                        <form id="trackForm" action="{{ route('search.track.order') }}" method="GET" class="needs-validation" novalidate>
                            <div class="input-group input-group-lg mb-3">
                                <input
                                    type="text"
                                    name="order_id"
                                    class="form-control"
                                    placeholder="Enter Order ID"
                                    required
                                    value="{{ $data['selected_order_id'] ?? '' }}">

                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-1"></i> Track
                                </button>
                                <a href="{{ route('user.track.order') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-1"></i> Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form End -->

            {{-- Order Details --}}
            @if (!empty($data['selected_order_id']) && empty($data['order']['order_id']))
                <div class="row g-4 mt-4 card">
                    <div class="col-12 text-center">
                        <h5 class="text-danger">No Order Found with ID "{{ $data['selected_order_id'] }}"</h5>
                    </div>
                </div>
            @elseif (!empty($data['order']['order_id']))
                <div class="row g-4 mt-4 card">
                    <div class="col-12">
                        <h5><strong>Order ID:</strong> {{ $data['order']['order_id'] }}</h5>
                        <hr>

                        @if (!empty($data['order']['status']))
                            <p><strong>Status:</strong>
                                <span
                                    class="badge
                    @if ($data['order']['status'] == 'pending') bg-info
                    @elseif($data['order']['status'] == 'completed') bg-success
                    @elseif($data['order']['status'] == 'cancelled') bg-danger
                    @else bg-warning @endif">
                                    {{ ucfirst($data['order']['status']) }}
                                </span>
                            </p>
                            <hr>
                        @endif

                        @if (!empty($data['order']['created_at']))
                            <p><strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($data['order']['created_at'])->format('Y-m-d') }}</p>
                            <hr>
                        @endif

                        @if (!empty($data['order']['products']) && count($data['order']['products']) > 0)
                            <h5>Product Names</h5>
                            <ol class="text-start d-inline-block">
                                <hr>
                                @foreach ($data['order']['products'] as $product)
                                    <li>{{ $product }}</li>
                                    <hr>
                                @endforeach
                            </ol>
                        @endif
                    </div>
                </div>
            @endif


        </div>
    </main>

    {{-- Script to change image on form submit --}}
    <script>
        document.getElementById('trackForm').addEventListener('submit', function() {
            document.getElementById('trackImage').src = "{{ asset('site/assets/img/loader.gif') }}";
        });
    </script>

@endsection
