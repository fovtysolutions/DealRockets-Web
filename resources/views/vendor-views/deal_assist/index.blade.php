@extends('layouts.back-end.app-partialseller')

@section('title', translate('Deal Assist'))

@section('content')
    <div class="content container-fluid">
        {{-- <h2 class="mb-4">Deal Assist List</h2> --}}

        <button class="btn btn--primary" data-toggle="modal" data-target="#createModal">Add Deal Assist</button>
        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>#</th>
                                    <th class="text-capitalize">User ID</th>
                                    <th class="text-center text-capitalize">Name</th>
                                    <th class="text-center text-capitalize">Email</th>
                                    <th class="text-center text-capitalize">Phone Number</th>
                                    <th class="text-center text-capitalize">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$dealAssists->empty())
                                    @foreach ($dealAssists as $deal)
                                        <tr>
                                            <td>{{ $deal->id }}</td>
                                            <td class="text-center">{{ $deal->user_id }}</td>
                                            <td class="text-center">{{ $deal->name }}</td>
                                            <td class="text-center">{{ $deal->email }}</td>
                                            <td class="text-center">{{ $deal->phone_number }}</td>
                                            <td class="d-flex flex-row gap-3">
                                                {{-- <button class="btn btn-outline--primary btn-sm square-btn"
                                                    id="ToggleEditModal" data-id="{{ $deal->id }}" data-toggle="modal"
                                                    data-target="#editModal"><i class="tio-edit"></i></button> --}}

                                                <form action="{{ route('dealassist.destroy', $deal->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm square-btn delete-data"
                                                        onclick="return confirm('Delete this entry?')"><i
                                                            class="tio-delete"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            No entries found.
                                        <td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if (!$dealAssists->empty())
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
                            <input type="hidden" name="user_id" class="form-control mb-2" value="{{ $deal->user_id }}"
                                placeholder="User ID" required>
                            <input type="text" name="name" class="form-control mb-2" value="{{ $deal->name }}"
                                placeholder="Name" required>
                            <input type="email" name="email" class="form-control mb-2" value="{{ $deal->email }}"
                                placeholder="Email" required>
                            <input type="text" name="phone_number" class="form-control mb-2"
                                value="{{ $deal->phone_number }}" placeholder="Phone Number" required>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            {{-- Do Nothing --}}
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
                        <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="text" name="phone_number" class="form-control mb-2" placeholder="Phone Number"
                            required>
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
        $('#ToggleEditModal').on('click', function() {
            console.log('Changed Id');
            var data = $(this).data('id');
            var here = $('#editmodalId');
            here.val(data);
        });
    </script>
@endpush
