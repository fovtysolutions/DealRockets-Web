@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.back-end.app-partial')
@section('title', translate('create_Role'))
@section('content')
    @php($direction = Session::get('direction'))@endphp
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2 text-capitalize">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{translate('employee_role_setup')}}
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <input type="hidden" name="searchValue" value="{{ request('searchValue') }}">
                        
                        <div class="row g-2 align-items-end">
                            <!-- Date From Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('date_from') }}</label>
                                <input type="date" name="from" class="form-control form-control-sm" 
                                       value="{{ request('from') }}">
                            </div>
                            
                            <!-- Date To Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('date_to') }}</label>
                                <input type="date" name="to" class="form-control form-control-sm" 
                                       value="{{ request('to') }}">
                            </div>

                            <!-- Sort Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('sort_by') }}</label>
                                <select name="sort_by" class="form-control form-control-sm">
                                    <option value="">{{ translate('default') }}</option>
                                    <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>{{ translate('name_asc') }}</option>
                                    <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>{{ translate('name_desc') }}</option>
                                    <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>{{ translate('date_asc') }}</option>
                                    <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>{{ translate('date_desc') }}</option>
                                </select>
                            </div>

                            <!-- Permission Level Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('permission_level') }}</label>
                                <select name="permission_level" class="form-control form-control-sm">
                                    <option value="">{{ translate('all') }}</option>
                                    <option value="full" {{ request('permission_level') == 'full' ? 'selected' : '' }}>{{ translate('full_access') }}</option>
                                    <option value="limited" {{ request('permission_level') == 'limited' ? 'selected' : '' }}>{{ translate('limited_access') }}</option>
                                    <option value="view_only" {{ request('permission_level') == 'view_only' ? 'selected' : '' }}>{{ translate('view_only') }}</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('status') }}</label>
                                <select name="status" class="form-control form-control-sm">
                                    <option value="">{{ translate('all') }}</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ translate('active') }}</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ translate('inactive') }}</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            <div class="col-md-1">
                                <a href="{{ route('admin.custom-role.list') }}" class="btn btn--primary w-100" style="height:35px;">
                                    <i class="tio-refresh"></i>
                                </a>
                            </div>
                            
                            <!-- Show Data Button -->
                            <div class="col-md-1">
                                <button type="submit" class="btn btn--primary w-100" style="height:35px;">
                                    <i class="tio-filter-list"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="px-3 py-4">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md-4 col-lg-6 mb-2 mb-sm-0">
                        <h5 class="d-flex align-items-center gap-2">
                            {{translate('employee_Roles')}}
                            <span class="badge badge-soft-dark radius-50 fz-12 ml-1">{{ count($roles) }}</span>
                        </h5>
                    </div>
                    <div class="col-md-8 col-lg-6 d-flex flex-wrap flex-sm-nowrap justify-content-sm-end gap-3">
                        <form action="{{url()->current()}}?search={{ request('searchValue') }}" method="GET">
                            <div class="input-group input-group-merge input-group-custom">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tio-search"></i>
                                    </div>
                                </div>
                                <input id="datatableSearch_" type="search" name="searchValue" class="form-control" placeholder="{{translate('search_role')}}"
                                        value="{{ request('searchValue') }}">
                                <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                            </div>
                        </form>
                        <div class="">
                            <button type="button" class="btn btn-outline--primary text-nowrap" data-toggle="dropdown">
                                <i class="tio-download-to"></i>
                                {{translate('export')}}
                                <i class="tio-chevron-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a class="dropdown-item" href="{{route('admin.custom-role.export',['searchValue'=>request('searchValue')])}}">
                                        <img width="14" src="{{dynamicAsset(path: 'public/assets/back-end/img/excel.png')}}" alt="">
                                        {{translate('excel')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-3">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table text-start">
                        <thead class="thead-light thead-50 text-capitalize table-nowrap">
                            <tr>
                                <th>{{translate('SL')}}</th>
                                <th>{{translate('role_name')}}</th>
                                <th>{{translate('modules')}}</th>
                                <th>{{translate('created_at')}}</th>
                                <th>{{translate('status')}}</th>
                                <th class="text-center">{{translate('action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$role['name']}}</td>
                                    <td class="text-capitalize">
                                        <a href="{{route('admin.custom-role.view',[$role['id']])}}"
                                            class="text-primary"
                                            title="{{translate('view') }}">
                                            {{ translate('View_Permissions') }}
                                        </a>
                                    </td>
                                    <td>{{date('d-M-y',strtotime($role['created_at']))}}</td>
                                    <td>
                                        <form action="{{route('admin.custom-role.employee-role-status')}}" method="post" id="employee-role-status{{$role['id']}}-form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$role['id']}}">
                                            <label class="switcher" for="employee-role-status{{$role['id']}}">
                                                <input type="checkbox" class="switcher_input toggle-switch-message" id="employee-role-status{{$role['id']}}" name="status" value="1" {{$role['status'] == 1?'checked':''}}
                                                    data-modal-id = "toggle-status-modal"
                                                    data-toggle-id = "employee-role-status{{$role['id']}}"
                                                    data-on-image = "employee-on.png"
                                                    data-off-image = "employee-off.png"
                                                    data-on-title = "{{translate('want_to_Turn_ON_Employee_Status').'?'}}"
                                                    data-off-title = "{{translate('want_to_Turn_OFF_Employee_Status').'?'}}"
                                                    data-on-message = "<p>{{translate('when_the_status_is_enabled_employees_can_access_the_system_to_perform_their_responsibilities')}}</p>"
                                                    data-off-message = "<p>{{translate('when_the_status_is_disabled_employees_cannot_access_the_system_to_perform_their_responsibilities')}}</p>">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                            <a href="{{route('admin.custom-role.update',[$role['id']])}}"
                                                class="btn btn-outline-primary" title="Edit">
                                                <i class="tio-edit"></i>Edit
                                            </a>
                                            <button type="button" class="btn btn-outline-danger delete-data-without-form"
                                                data-action="{{route('admin.custom-role.delete')}}"
                                                title="Delete" data-id="{{$role['id']}}">
                                                Delete<i class="tio-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(count($roles)==0)
                @include('layouts.back-end._empty-state',['text'=>'no_data_found'],['image'=>'default'])
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/custom-role.js')}}"></script>
@endpush
