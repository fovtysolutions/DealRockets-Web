@extends('layouts.back-end.app-partial')

@section('title', translate('Deal Assist'))

@section('content')
<div class="container mt-4">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <div class="card-body p-0">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-2 col-sm-4 col-6">
                            <label class="form-label mb-1 small">{{ translate('role') }}</label>
                            <select name="role" class="form-control form-control-sm">
                                <option value="">{{ translate('all_roles') }}</option>
                                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>
                                    {{ translate('customer') }}
                                </option>
                                <option value="guest" {{ request('role') == 'guest' ? 'selected' : '' }}>
                                    {{ translate('guest') }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-4 col-6">
                            <label class="form-label mb-1 small">{{ translate('date_from') }}</label>
                            <input type="date" name="date_from" class="form-control form-control-sm" 
                                value="{{ request('date_from') }}">
                        </div>

                        <div class="col-md-2 col-sm-4 col-6">
                            <label class="form-label mb-1 small">{{ translate('date_to') }}</label>
                            <input type="date" name="date_to" class="form-control form-control-sm" 
                                value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-2 col-sm-4 col-6">
                            <label class="form-label mb-1 small">{{ translate('sort_by') }}</label>
                            <select name="sort_by" class="form-control form-control-sm">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                                    {{ translate('date_created') }}
                                </option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>
                                    {{ translate('name') }}
                                </option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>
                                    {{ translate('email') }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <a href="{{ route('dealassist.index') }}"
                                class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                {{ translate('reset') }}
                            </a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn--primary w-100" style="height:35px; padding:5px 10px 5px 10px;">
                                {{ translate('show_data') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="input-group input-group-custom input-group-merge">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input id="datatableSearch_" type="search" name="search" class="form-control"
                                        placeholder="{{ translate('search_by_name_email_phone') }}"
                                        aria-label="Search entries" value="{{ request('search') }}">
                                    <input type="hidden" value="{{ request('role') }}" name="role">
                                    <input type="hidden" value="{{ request('date_from') }}" name="date_from">
                                    <input type="hidden" value="{{ request('date_to') }}" name="date_to">
                                    <input type="hidden" value="{{ request('sort_by') }}" name="sort_by">
                                    <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-8 mt-3 mt-lg-0 d-flex flex-wrap gap-3 justify-content-lg-end">
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline--primary" data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{ translate('export') }}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <img width="14" src="{{ dynamicAsset(path: 'public/assets/back-end/img/excel.png') }}" alt="">
                                            {{ translate('excel') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-view p-3">
            @if(!$dealAssists->isEmpty())
                <div class="table-responsive">
                    <table id="datatable"
                        style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                        class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100">
                        <thead class="thead-light thead-50 text-capitalize table-nowrap">
                            <tr>
                                <th>#</th>
                                <th>{{ translate('name') }}</th>
                                <th>{{ translate('email') }}</th>
                                <th>{{ translate('phone_number') }}</th>
                                <th>{{ translate('role') }}</th>
                                <th>{{ translate('date_created') }}</th>
                                <th class="text-center">{{ translate('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dealAssists as $key => $deal)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{ $deal->name }}</td>
                                <td>{{ $deal->email }}</td>
                                <td>{{ $deal->phone_number ?: 'N/A' }}</td>
                                <td>
                                    @if($deal->role == 'customer')
                                        <span class="badge bg-success">Customer</span>
                                    @else
                                        <span class="badge bg-secondary">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $deal->created_at->format('M d, Y H:i') }}</td>
                                <td class="text-center">
                                    <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                        <button class="btn btn-outline-info" id="ToggleEditModal" data-id="{{ $deal->id }}" data-toggle="modal" data-target="#editModal" title="View">
                                            <i class="tio-invisible"></i>View
                                        </button>
                                        <form action="{{ route('dealassist.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="d-inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">Delete
                                                <i class="tio-delete"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    
                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        {{ $dealAssists->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <p class="text-muted mb-0">No entries found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

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
    $(document).on('click', '#ToggleEditModal', function(){
        console.log('Changed Id');
        var data = $(this).data('id');
        var here = $('#editmodalId');
        here.val(data);
    });
</script>
@endpush