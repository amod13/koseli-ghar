@extends('site.main.app')
@section('content')
    @include('alert.sitemessage')

    <main class="bg-light py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="h3 m-0">My Orders</h1>
                <a href="{{ route('site.user.profile', $data['userId']) }}" class="t-y-btn">
                    <i class="bi bi-arrow-left me-1"></i> Back to Profile
                </a>
            </div>

            <!-- User Info Row -->
            @if (count($data['orders']) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Filter Orders</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.orders.filter') }}" method="get">
                        <div class="row g-3">

                            <div class="col-md-3">
                                <label for="order_id" class="form-label">Order ID</label>
                                <input type="text" name="order_id" id="order_id" class="form-control" placeholder="Enter order id" value="{{ $data['selected_order_id'] ?? '' }}">
                            </div>
                            <div class="col-md-3">
                                <label for="product_name" class="form-label">Product Name</label>
                                <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" value="{{ $data['selected_product_name'] ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label for="min_price" class="form-label">Min Price</label>
                                <input type="number" name="min_price" id="min_price" class="form-control" placeholder="0" value="{{ $data['selected_min_price'] ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label for="max_price" class="form-label">Max Price</label>
                                <input type="number" name="max_price" id="max_price" class="form-control" placeholder="1000" value="{{ $data['selected_max_price'] ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label for="deliver_status" class="form-label">Select Status</label>
                                <br>
                                <select name="deliver_status" id="deliver_status" class="form-select">
                                    <option selected disabled>Select Status</option>
                                    <option value="pending" {{ isset($data['selected_deliver_status']) && $data['selected_deliver_status'] == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ isset($data['selected_deliver_status']) && $data['selected_deliver_status'] == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ isset($data['selected_deliver_status']) && $data['selected_deliver_status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ isset($data['selected_deliver_status']) && $data['selected_deliver_status'] == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>


                            <div class="col-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('user.orders', $data['userId']) }}" class="btn btn-outline-danger">Reset</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <div class="row g-4 justify-content-center mt-4">
                <div class="col-lg-12">
                    <div class="border rounded p-4 bg-white h-100">
                        <table class="table table-striped product-list mb-5">
                            <thead>
                                <tr>
                                    <th>Order Id.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Original Price</th>
                                    <th>Qty.</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($data['orders'] as $order => $item)
                                    <tr>
                                        <td>{{ $item->order_id }} #</td>
                                        <td><img src="{{ asset('uploads/images/product/thumbnailImage/' . $item->image) }}" alt="" style="height: 80px;width:80px;"></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ number_format($item->discounted_price,2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->discounted_price * $item->quantity }}</td>
                                        <td class="status__badge">
                                            @php
                                                $statusClass = match ($item->status) {
                                                    'pending' => 'bg-info',
                                                    'processing' => 'bg-warning',
                                                    'completed' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp

                                            <span class="badge {{ $statusClass }} status-badge" data-bs-toggle="modal"
                                                data-bs-target="#orderStatusModal" data-order-id="{{ $item->order_id }}"
                                                data-status="{{ $item->status }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="border rounded p-5 bg-white text-center shadow-sm">
                        <h4 class="mb-3 text-danger">No Orders Found</h4>
                        <p class="text-muted">Looks like you haven't placed any orders yet.</p>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-cart"></i> Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>
@endsection

