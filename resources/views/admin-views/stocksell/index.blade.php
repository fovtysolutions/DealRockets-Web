@extends('layouts.back-end.app')

@section('title', translate('Stock_List'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container mt-5 mb-5">
    <h2 class="mb-4">Stock List</h2>
    
    <!-- Filter Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.stock.index') }}" method="GET" class="row g-3">
                <!-- Search by Name -->
                <div class="col-md-4">
                    <label for="searchName" class="form-label">Search by Name</label>
                    <input type="text" id="searchName" class="form-control" name="name" placeholder="Enter product name">
                </div>
                <!-- Filter by Status -->
                <div class="col-md-4">
                    <label for="filterStatus" class="form-label">Filter by Status</label>
                    <select id="filterStatus" class="form-control" name="status">
                        <option selected value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <!-- Filter by Quantity -->
                <div class="col-md-4">
                    <label for="quantityRange" class="form-label">Filter by Quantity</label>
                    <div class="input-group">
                        <input type="number" name="minqty" id="minQuantity" class="form-control" placeholder="Min" min="0">
                        <span class="input-group-text">-</span>
                        <input type="number" name="maxqty" id="maxQuantity" class="form-control" placeholder="Max" min="0">
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <button type="reset" class="btn btn-secondary">Reset Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock List Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                {{-- <th>Description</th> --}}
                <th>Quantity</th>
                <th>Status</th>
                <th>View Product</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $value->name }}</td>
                {{-- <td>{!! $value->description !!}</td> --}}
                <td>{{ $value->quantity }}</td>
                <td>
                    @if($value->status == 'active')
                        <span class="badge bg-success">Active</span>
                    @elseif($value->status == 'inactive')
                        <span class="badge bg-secondary">Inactive</span>
                    @elseif($value->status == 'rejected')
                        <span class="badge bg-danger">Rejected</span>
                    @else
                        <span class="badge bg-warning">Invalid</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.view',['addedBy'=>"$value->user_id",'id'=>"$value->product_id"]) }}">
                        <span>See Product</span>
                    </a>
                </td>
                <td>
                    <span class="d-flex gap-2">
                        <a class="btn btn-info btn-sm" href="{{ route('admin.stock.show', ['id' => $value->id]) }}">
                            View
                        </a>
                        <a class="btn btn-warning btn-sm" href="{{ route('admin.stock.edit', ['id' => $value->id]) }}">
                            Edit
                        </a>
                        <form action="{{ route('admin.stock.destroy',['id'=>$value->id]) }}" method="post">
                            @csrf @method('delete')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{$items->links()}}
</div>

@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
@endpush
