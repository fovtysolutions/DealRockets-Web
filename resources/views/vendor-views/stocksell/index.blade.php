@extends('layouts.back-end.app-partialseller')

@section('title', translate('Stock_Index'))

@section('content')
    <div class="content container-fluid">
        {{-- <h2 class="mb-4">Stock List</h2> --}}

        <!-- Filter Bar -->
        <div>
            <form action="{{ route('vendor.stock.index') }}" method="GET" class="row" id="form-filter">
                <!-- Search by Name -->
                <div class="col-md-3">
                    <label for="searchName" class="form-label" style="color: var(--title-color);font-weight: 700;">Search by
                        Name</label>
                    <input type="text" id="searchName" class="form-control" name="name"
                        placeholder="Enter product name" style="box-shadow: 0px 3px 14px rgb(176 193 249 / 43%);">
                </div>
                <!-- Filter by Status -->
                <div class="col-md-3">
                    <label for="filterStatus" class="form-label" style="color: var(--title-color);font-weight: 700;">Filter
                        by Status</label>
                    <select id="filterStatus" class="form-control" name="status"
                        style="box-shadow: 0px 3px 14px rgb(176 193 249 / 43%);">
                        <option selected value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <!-- Filter by Enabled Status -->
                <div class="col-md-3">
                    <label for="filterEnabled" class="form-label" style="color: var(--title-color);font-weight: 700;">Filter
                        by Enabled Status</label>
                    <select id="filterEnabled" class="form-control" name="is_enabled"
                        style="box-shadow: 0px 3px 14px rgb(176 193 249 / 43%);">
                        <option selected value="">All</option>
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>
                <!-- Filter by Quantity -->
                <div class="col-md-3">
                    <label for="quantityRange" class="form-label" style="color: var(--title-color);font-weight: 700;">Filter
                        by Quantity</label>
                    <div class="input-group">
                        <input type="number" name="minqty" id="minQuantity" class="form-control" placeholder="Min"
                            min="0" style="box-shadow: 0px 3px 14px rgb(176 193 249 / 43%);">
                        <span class="input-group-text border-0">-</span>
                        <input type="number" name="maxqty" id="maxQuantity" class="form-control" placeholder="Max"
                            min="0" style="box-shadow: 0px 3px 14px rgb(176 193 249 / 43%);">
                    </div>
                </div>
            </form>
        </div>

        <!-- Stock List Table -->
        @if ($items->isEmpty())
            No Stock Avaliable
        @else
            <div class="row mt-20">
                <div class="col-md-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-capitalize">Product</th>
                                        <th class="text-center text-capitalize">Description</th>
                                        <th class="text-center text-capitalize">Quantity</th>
                                        <th class="text-center text-capitalize">Status</th>
                                        <th class="text-center text-capitalize">Enabled Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                {{ $value->product->name ?? ($value->product_id) }}</td>
                                            <td class="text-center">{{ $value->description }}</td>
                                            <td class="text-center">{{ $value->quantity }}</td>
                                            <td class="text-center">
                                                @if ($value->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($value->status == 'inactive')
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @elseif($value->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning">Invalid</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($value->is_enabled)
                                                    <span class="badge bg-success">Enabled</span>
                                                @else
                                                    <span class="badge bg-danger">Disabled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="d-flex gap-2">
                                                    <a class="btn btn-outline-info"
                                                        href="{{ route('vendor.stock.show', ['id' => $value->id]) }}">
                                                        <i class="tio-invisible"></i> View
                                                    </a>
                                                    <a class="btn btn-outline--primary"
                                                        href="{{ route('vendor.stock.edit', ['id' => $value->id]) }}">
                                                        <i class="tio-edit"></i> Edit
                                                    </a>
                                                    @if ($value->is_enabled)
                                                        <form action="{{ route('vendor.stock.disable', ['id' => $value->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <button class="btn btn-outline-danger" type="submit"><i
                                                                    class="tio-toggle-off"></i> Disable</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('vendor.stock.enable', ['id' => $value->id]) }}"
                                                            method="post">
                                                            @csrf
                                                            <button class="btn btn-outline-success" type="submit"><i
                                                                    class="tio-toggle-on"></i> Enable</button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('vendor.stock.destroy', ['id' => $value->id]) }}"
                                                        method="post">
                                                        @csrf @method('delete')
                                                        <button class="btn btn-outline-danger delete-data"><i
                                                                class="tio-delete"></i> Delete</button>
                                                    </form>
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                {{ $items->links() }}
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            const $form = $('#form-filter');

            // Submit when dropdown or number inputs change
            $form.find('select, input[type="number"]').on('change', function() {
                $form.submit();
            });

            // Submit on Enter key for the text input
            $('#searchName').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $form.submit();
                }
            });
        });
    </script>
@endsection
