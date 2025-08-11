@extends('layouts.back-end.app-partial')

@section('title', translate('employee_list'))

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/employee.png')}}" width="20" alt="">
                {{translate('employee_list')}}
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

                            <!-- Role Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('role') }}</label>
                                <select name="admin_role_id" class="form-control form-control-sm">
                                    <option value="">{{ translate('all') }}</option>
                                    @foreach($employee_roles as $employee_role)
                                        <option value="{{ $employee_role['id'] }}" {{ request('admin_role_id') == $employee_role['id'] ? 'selected' : '' }}>
                                            {{ Str::limit($employee_role['name'], 12) }}
                                        </option>
                                    @endforeach
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
                                <a href="{{ route('admin.employee.list') }}" class="btn btn--primary w-100" style="height:35px;">
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

        <div class="card">
            <div class="card-header flex-wrap gap-10">
                <div class="px-sm-3 py-4 flex-grow-1">
                    <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center">
                        <div class="">
                            <h5 class="mb-0 text-capitalize gap-2">
                                {{translate('employee_table')}}
                                <span class="badge badge-soft-dark radius-50 fz-12">{{$employees->total()}}</span>
                            </h5>
                        </div>
                        <div class="align-items-center d-flex gap-3 justify-content-lg-end flex-wrap flex-lg-nowrap flex-grow-1">
                            <div class="">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input type="search" name="searchValue" class="form-control"
                                                placeholder="{{translate('search_by_name_or_email_or_phone')}}"
                                                value="{{ request('searchValue') }}" required>
                                        <button type="submit" class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="d-flex gap-2 align-items-center text-left">
                                        <div class="">
                                            <select class="form-control text-ellipsis min-w-200" name="admin_role_id">
                                                <option value="all" {{ request('employee_role') == 'all' ? 'selected' : '' }}>{{translate('all')}}</option>
                                                @foreach($employee_roles as $employee_role)
                                                    <option value="{{ $employee_role['id'] }}" {{ request('admin_role_id') == $employee_role['id'] ? 'selected' : '' }}>
                                                            {{ ucfirst($employee_role['name']) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="btn btn--primary px-4 w-100 text-nowrap">
                                                {{ translate('filter')}}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="dropdown">
                                <button type="button" class="btn btn-outline--primary text-nowrap" data-toggle="dropdown">
                                    <i class="tio-download-to"></i>
                                    {{translate('export')}}
                                    <i class="tio-chevron-down"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a class="dropdown-item" href="{{route('admin.employee.export',['role'=>request('admin_role_id'),'searchValue'=>request('searchValue')])}}">
                                            <img width="14" src="{{dynamicAsset(path: 'public/assets/back-end/img/excel.png')}}" alt="">
                                            {{translate('excel')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="">
                                <a href="{{route('admin.employee.add-new')}}" class="btn btn--primary text-nowrap">
                                    <i class="tio-add"></i>
                                    <span class="text ">{{translate('add_new')}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="datatable"
                            style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};"
                            class="table table-hover table-borderless table-thead-bordered table-align-middle card-table w-100">
                        <thead class="thead-light thead-50 text-capitalize table-nowrap">
                        <tr>
                            <th>{{translate('SL')}}</th>
                            <th>{{translate('name')}}</th>
                            <th>{{translate('email')}}</th>
                            <th>{{translate('phone')}}</th>
                            <th>{{translate('role')}}</th>
                            <th>{{translate('status')}}</th>
                            <th class="text-center">{{translate('action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $key => $employee)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td class="text-capitalize">
                                    <div class="media align-items-center gap-10">
                                        <img class="rounded-circle avatar avatar-lg" alt=""
                                             src="{{getStorageImages(path: $employee->image_full_url,type:'backend-profile')}}">
                                        <div class="media-body">
                                            {{$employee['name']}}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{$employee['email']}}
                                </td>
                                <td>{{$employee['phone']}}</td>
                                <td>{{$employee?->role['name'] ?? translate('role_not_found')}}</td>
                                <td>
                                    @if($employee['id'] == 1)
                                        <label class="badge badge-primary-light">{{ translate('admin') }}</label>
                                    @else
                                        <form action="{{route('admin.employee.status')}}" method="post" id="employee-id-{{$employee['id']}}-form" class="employee_id_form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$employee['id']}}">
                                            <label class="switcher">
                                                <input type="checkbox" class="switcher_input toggle-switch-message" value="1" id="employee-id-{{$employee['id']}}" name="status"
                                                       {{$employee->status?'checked':''}}
                                                       data-modal-id = "toggle-status-modal"
                                                       data-toggle-id = "employee-id-{{$employee['id']}}"
                                                       data-on-image = "employee-on.png"
                                                       data-off-image = "employee-off.png"
                                                       data-on-title = "{{translate('want_to_Turn_ON_Employee_Status').'?'}}"
                                                       data-off-title = "{{translate('want_to_Turn_OFF_Employee_Status').'?'}}"
                                                       data-on-message = "<p>{{translate('if_enabled_this_employee_can_log_in_to_the_system_and_perform_his_role')}}</p>"
                                                       data-off-message = "<p>{{translate('if_disabled_this_employee_can_not_log_in_to_the_system_and_perform_his_role')}}</p>">`)">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($employee['id'] == 1)
                                        <label class="badge badge-primary-light">{{ translate('default') }}</label>
                                    @else
                                        <div class="" role="group" style="display: flex;gap: 10px;align-items: center;">
                                            <a href="{{route('admin.employee.view',['id'=>$employee['id']])}}"
                                               class="btn btn-outline-info" title="View">
                                                <i class="tio-invisible"></i>View
                                            </a>
                                            <a href="{{route('admin.employee.update',[$employee['id']])}}"
                                               class="btn btn-outline-primary" title="Edit">
                                                <i class="tio-edit"></i>Edit
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        {{$employees->links()}}
                    </div>
                </div>
                @if(count($employees)==0)
                    <div class="w-100">
                        @include('layouts.back-end._empty-state',['text'=>'no_employee_found'],['image'=>'default'])
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
