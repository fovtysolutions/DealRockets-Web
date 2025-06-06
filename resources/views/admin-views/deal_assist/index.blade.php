@extends('layouts.back-end.app-partial')

@section('title', translate('Deal Assist'))

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Deal Assist List</h2>

    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal">Add Deal Assist</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($dealAssists->empty())
                @foreach($dealAssists as $deal)
                <tr>
                    <td>{{ $deal->id }}</td>
                    <td>{{ $deal->user_id }}</td>
                    <td>{{ $deal->name }}</td>
                    <td>{{ $deal->email }}</td>
                    <td>{{ $deal->phone_number }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" id="ToggleEditModal" data-id="{{ $deal->id }}" data-toggle="modal" data-target="#editModal">Edit</button>

                        <form action="{{ route('dealassist.destroy', $deal->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this entry?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @else
                <p>No entries found.</p>
            @endif
        </tbody>
    </table>

    @if(!$dealAssists->empty())
    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('dealassist.update') }}">
                @csrf
                <input type="hidden" id="editmodalId" name="id" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Deal Assist</h5>
                    <button type="button" class="btn-close" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <input type="number" name="user_id" class="form-control mb-2" value="{{ $deal->user_id }}" placeholder="User ID" required>
                    <input type="text" name="name" class="form-control mb-2" value="{{ $deal->name }}" placeholder="Name" required>
                    <input type="email" name="email" class="form-control mb-2" value="{{ $deal->email }}" placeholder="Email" required>
                    <input type="text" name="phone_number" class="form-control mb-2" value="{{ $deal->phone_number }}" placeholder="Phone Number" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('dealassist.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Deal Assist</h5>
                    <button type="button" class="btn-close" data-dismiss="modal">X</button>
                </div>
                <div class="modal-body">
                    <input type="number" name="user_id" class="form-control mb-2" placeholder="User ID" required>
                    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="text" name="phone_number" class="form-control mb-2" placeholder="Phone Number" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('#ToggleEditModal').on('click',function(){
        console.log('Changed Id');
        var data = $(this).data('id');
        var here = $('#editmodalId');
        here.val(data);
    });
</script>
@endpush