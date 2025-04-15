@php
    use Illuminate\Support\Facades\Session;
@endphp
@extends('layouts.back-end.app')

@section('title', translate('edit_Role'))

@section('content')
    @php($direction = Session::get('direction'))@endphp
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2 text-capitalize">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{translate('role_update')}}
            </h2>
        </div>
        <div class="card">
            <div class="card-body">
                <form id="submit-create-role" action="{{route('admin.custom-role.update',[$role['id']])}}" method="post" class="text-start">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="hidden" name="id" value="{{$role['id']}}">
                            <div class="form-group mb-4">
                                <label for="name" class="title-color">{{translate('role_name')}}</label>
                                <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name"
                                       aria-describedby="emailHelp"
                                       placeholder="{{translate('ex').':'.translate('store')}}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-4 flex-wrap">
                        <label for="module" class="title-color mb-0">{{translate('module_permission').':'}}</label>
                        <div class="form-group d-flex gap-2">
                            <input type="checkbox" id="select-all" class="cursor-pointer">
                            <label class="title-color mb-0 cursor-pointer text-capitalize"
                                   for="select-all">{{translate('select_all')}}</label>
                        </div>
                    </div>

                    <div class="row">
                        @foreach($modules as $module)
                            <div class="col-sm-6 col-lg-3">
                                <div class="form-group d-flex gap-2">
                                    <input 
                                        type="checkbox" 
                                        name="module[]" 
                                        value="{{ $module['key'] }}" 
                                        class="module-permission" 
                                        id="{{ $module['key'] }}"
                                        {{in_array($module['key'],(array)json_decode($role['modules']))?'checked':''}}
                                    >
                                    <label class="title-color mb-0"
                                            for="{{ $module['key'] }}">{{translate($module['name'])}}</label>
                                </div>
                            </div>
                        @endforeach
                        <div class="table-responsive col-lg-12">
                            <table class="table table-hover table-borderless table-thead-bordered">
                                <thead style="background-color: white;">
                                    <tr>
                                        <th>Permission Name</th>
                                        @foreach ($continents as $continent)
                                            <th class="text-center">
                                                <input type="checkbox" data-continent="{{ $continent }}" class="cursor-pointer select-all-specific">
                                                {{ $continent }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $module['name'] }}</td>
                                            @foreach ($continents as $continent)
                                                @php
                                                    $module_access = $role['module_access'] ? json_decode($role['module_access'], true) : [];
                                                    $permissions = $module_access[$continent][$module['key']] ?? [];
                                                    $permissions = is_array($permissions) ? $permissions : [];
                                                @endphp
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @foreach ($module['permissions'] as $permission)
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    data-continent="{{ $continent }}"
                                                                    data-key="{{ $module['key'] }}"
                                                                    data-permission="{{ $permission }}" 
                                                                    name="modules[{{ $continent }}][{{ $module['key'] }}][{{ $permission }}]" 
                                                                    value="yes" 
                                                                    class="form-check-input module-permission module-permission-special module-permission-{{ $continent }}" 
                                                                    id="{{ $continent }}_{{ $module['key'] }}_{{ $permission }}"
                                                                    @if(isset($permissions[$permission]) && $permissions[$permission] === 'yes') 
                                                                        checked 
                                                                    @endif
                                                                >
                                                                <label class="form-check-label" 
                                                                    for="{{ $continent }}_{{ $module['key'] }}_{{ $permission }}">
                                                                    {{ ucfirst($permission) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3">
                        <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                        <button type="submit" class="btn btn--primary">{{translate('update')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/admin/custom-role.js') }}"></script>
@endpush
