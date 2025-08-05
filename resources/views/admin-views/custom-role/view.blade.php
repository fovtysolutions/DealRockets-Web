@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.back-end.app-partial')
@section('title', translate('view_Role'))
@section('content')
    @php($direction = Session::get('direction'))@endphp
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2 text-capitalize">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{translate('employee_role_details')}}
            </h2>
        </div>
        <div class="card mt-3">
            <div class="px-3 py-4">
                <h5 class="text-capitalize">{{translate('role_name')}}: <strong>{{ $role['name'] }}</strong></h5>
                <h5 class="text-capitalize">{{translate('created_at')}}: <strong>{{ date('d-M-y', strtotime($role['created_at'])) }}</strong></h5>
                <h5 class="text-capitalize">{{translate('status')}}: 
                    <strong>
                        @if($role['status'] == 1)
                            {{translate('Active')}}
                        @else
                            {{translate('Inactive')}}
                        @endif
                    </strong>
                </h5>
            </div>
            <div class="pb-3">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless table-thead-bordered table-align-middle card-table text-start">
                        <thead class="thead-light thead-50 text-capitalize table-nowrap">
                            <tr>
                                <th>{{translate('continent')}}</th>
                                <th>{{translate('modules')}}</th>
                                <th>{{translate('permissions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $moduleAccess = json_decode($role['module_access'], true);
                            @endphp

                            @if(is_array($moduleAccess))
                                @foreach($moduleAccess as $continent => $modules)
                                    @foreach($modules as $module => $permissions)
                                        <tr>
                                            <td class="text-capitalize"><strong>{{ $continent }}</strong></td>
                                            <td class="text-capitalize"><strong>{{ $module }}</strong></td>
                                            <td>
                                                @foreach($permissions as $permission => $value)
                                                    {{ ucfirst($permission) }}: {{ $value }}
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">{{ translate('No data available') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
