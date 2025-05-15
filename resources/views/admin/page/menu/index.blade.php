@extends('admin.main.app')
@section('content')
@include('alert.message')
    <div class="row">
        <div class="col-xl-12 mx-auto">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between">
                        <h4 class="mb-0">Menu Table</h4>
                        <a href="{{ route('menu.create') }}" class="btn btn-primary btn-sm">+ Add New</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="sortable-menu">
                        @foreach ($menus as $menu)
                            <div class="card mb-2" data-id="{{ $menu->id }}">
                                <div class="card-header d-flex justify-content-between">
                                    <span><i class="fa fa-arrows-alt mr-2"></i>{{ $menu->title }}</span>

                                    <!-- Edit and Delete Buttons for Parent Menu -->
                                    <div class="btn-group ml-2">
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-default">
                                            <span class="fa fa-edit"></span>
                                        </a>
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-default">
                                                <span class="fa fa-trash"></span>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Child menus (if any) -->
                                @if ($menu->children)
                                    <div class="card-body">
                                        @foreach ($menu->children as $child)
                                            <div class="card mb-2" data-id="{{ $child->id }}">
                                                <div class="card-header d-flex justify-content-between">
                                                    <span><i class="fa fa-arrows-alt mr-2"></i>{{ $child->title }}</span>

                                                    <!-- Edit and Delete Buttons for Child Menu -->
                                                    <div class="btn-group ml-2">
                                                        <a href="{{ route('menu.edit', $child->id) }}" class="btn btn-sm btn-default">
                                                            <span class="fa fa-edit"></span>
                                                        </a>
                                                        <form action="{{ route('menu.destroy', $child->id) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-default">
                                                                <span class="fa fa-trash"></span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Recursively check for further children -->
                                                @if ($child->children)
                                                    <div class="card-body">
                                                        @foreach ($child->children as $subChild)
                                                            <div class="card mb-2" data-id="{{ $subChild->id }}">
                                                                <div class="card-header d-flex justify-content-between">
                                                                    <span><i class="fa fa-arrows-alt mr-2"></i>{{ $subChild->title }}</span>

                                                                    <!-- Edit and Delete Buttons for Sub Child Menu -->
                                                                    <div class="btn-group ml-2">
                                                                        <a href="{{ route('menu.edit', $subChild->id) }}" class="btn btn-sm btn-default">
                                                                            <span class="fa fa-edit"></span>
                                                                        </a>
                                                                        <form action="{{ route('menu.destroy', $subChild->id) }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-default">
                                                                                <span class="fa fa-trash"></span>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>

                                                                <!-- Recursively check for further children -->
                                                                @if ($subChild->children)
                                                                    <div class="card-body">
                                                                        @foreach ($subChild->children as $thirdLayerChild)
                                                                            <div class="card mb-2" data-id="{{ $thirdLayerChild->id }}">
                                                                                <div class="card-header d-flex justify-content-between">
                                                                                    <span><i class="fa fa-arrows-alt mr-2"></i>{{ $thirdLayerChild->title }}</span>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Include SortableJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            function applySortable(element) {
                new Sortable(element, {
                    animation: 150,
                    group: 'nested',
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onEnd: function () {
                        saveMenuOrder();
                    }
                });

                // Apply recursively to child cards
                $(element).children('.card').each(function() {
                    var childList = $(this).children('.card-body');
                    if (childList.length > 0) {
                        applySortable(childList[0]);
                    }
                });
            }

            applySortable(document.getElementById('sortable-menu'));

            // Recursive function to build tree
            function buildTree(list) {
                var items = [];
                $(list).children('.card').each(function(index, card) {
                    var id = $(card).data('id');
                    var childList = $(card).children('.card-body');
                    items.push({
                        id: id,
                        position: index + 1,
                        children: childList.length > 0 ? buildTree(childList) : []
                    });
                });
                return items;
            }

            function saveMenuOrder() {
                var order = buildTree($('#sortable-menu'));
                console.log(order); // For testing

                $.ajax({
                    url: "{{ route('menu.updateOrder') }}",
                    method: "POST",
                    data: {
                        order: order,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Order Saved Successfully!');
                    },
                    error: function () {
                        alert('Something went wrong!');
                    }
                });
            }
        });
    </script>

    <style>
        #sortable-menu .card {
            cursor: grab;
        }

        #sortable-menu .card:active {
            cursor: grabbing;
        }

        /* Indentation for child menu items */
        #sortable-menu .card-body {
            padding-left: 20px;
        }

        /* Aligning buttons on the right */
        .btn-group {
            position: absolute;
            right: 10px;
        }

        /* Add spacing between the cards */
        #sortable-menu .card {
            margin-bottom: 10px;
        }

        /* Indentation for deeper levels */
        #sortable-menu .card-body {
            padding-left: 30px;
        }
    </style>
@endpush
