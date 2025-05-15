@extends('admin.main.app')
@section('content')
    @include('alert.message')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('order.manage.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    {{-- Search Filter --}}
    <div class="col-12 col-lg-12 d-flex">
        <div class="card radius-15 w-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <h5 class="mb-0">Orders Search Filter</h5>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <div class="card radius-15 border shadow-none mb-0">
                            <div class="card-body">
                                <form action="{{ route('order.manage.search') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        {{-- Search by Date --}}
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="fromdate" class="form-label">From</label>
                                                <input type="date" class="form-control" name="from_date" id="date"
                                                    value="{{ old('from_date', $data['selected_from_date'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="todate" class="form-label">To</label>
                                                <input type="date" class="form-control" name="to_date" id="date"
                                                    value="{{ old('to_date', $data['selected_to_date'] ?? '') }}">
                                            </div>
                                        </div>
                                        {{-- Search by Status --}}
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Select Status</label>
                                                <select class="form-select single-select" name="status" id="ProductStatus">
                                                    <option disabled selected>--- Select Status ---</option>
                                                    @foreach (['pending', 'processing', 'completed', 'cancelled'] as $status)
                                                        <option value="{{ $status }}"
                                                            {{ old('status', $data['selected_status'] ?? '') == $status ? 'selected' : '' }}>
                                                            {{ ucfirst($status) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- Submit and Reset --}}
                                        <div class="col-md-2">
                                            <div class="mb-3 d-flex align-items-end gap-2" style="margin-top: 33px;">
                                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                                <a href="{{ route('order.manage.index') }}"
                                                    class="btn btn-danger btn-sm">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Search Filter --}}


    {{-- Table List --}}
    @if ($data['orders']->isEmpty())
        <div class="card"></div>
        <div class="card-body">
            <div class="no__data_found">
                <div class="text-center">
                    <h5>No Record Found</h5>
                </div>
            </div>
        </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered dataTable no-footer" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>Order Id.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($data['orders'] as $order => $item)
                                <tr>
                                    <td>{{ $item->order_id }} #</td>
                                    <td>{{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }} </td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->total_price }}</td>
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
    @endif


    <!-- Modal -->
    <div class="modal fade" id="orderStatusModal" tabindex="-1" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Status Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- #region Order Status Modal -->
                    <form id="orderStatusForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="orderId" value="">
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Order Status</label>
                            <select class="form-select" id="orderStatus" name="status">
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="submit__btn float-end">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusBadges = document.querySelectorAll('.status-badge');
            const form = document.getElementById('orderStatusForm');

            statusBadges.forEach(badge => {
                badge.addEventListener('click', function() {
                    debugger;
                    const orderId = this.getAttribute('data-order-id');
                    const status = this.getAttribute('data-status');

                    // Set the selected option in the dropdown
                    const statusSelect = document.getElementById('orderStatus');
                    if (statusSelect) {
                        statusSelect.value = status;
                    }

                    // Update form action URL if needed
                    const actionUrl = "{{ route('order.manage.status', '__id__') }}".replace(
                        '__id__', orderId);
                    form.setAttribute('action', actionUrl);

                    // Set hidden input value
                    form.querySelector('input[name="orderId"]').value = orderId;
                });
            });
        });
    </script>
@endpush
