@php use Carbon\Carbon; @endphp
@extends('layouts.back-end.app-partial')

@section('title', translate('support_Ticket'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/support_ticket.png')}}" alt="">
                {{translate('support_ticket')}}
                <span class="badge badge-soft-dark radius-50 fz-14">{{ $tickets->total() }}</span>
            </h2>
        </div>
        <!-- Support Ticket Filters -->
        <div class="container-fluid p-0 mt-20">
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
                                    <option value="subject_asc" {{ request('sort_by') == 'subject_asc' ? 'selected' : '' }}>{{ translate('subject_asc') }}</option>
                                    <option value="subject_desc" {{ request('sort_by') == 'subject_desc' ? 'selected' : '' }}>{{ translate('subject_desc') }}</option>
                                    <option value="priority_asc" {{ request('sort_by') == 'priority_asc' ? 'selected' : '' }}>{{ translate('priority_asc') }}</option>
                                    <option value="priority_desc" {{ request('sort_by') == 'priority_desc' ? 'selected' : '' }}>{{ translate('priority_desc') }}</option>
                                    <option value="created_asc" {{ request('sort_by') == 'created_asc' ? 'selected' : '' }}>{{ translate('date_asc') }}</option>
                                    <option value="created_desc" {{ request('sort_by') == 'created_desc' ? 'selected' : '' }}>{{ translate('date_desc') }}</option>
                                </select>
                            </div>

                            <!-- Priority Filter -->
                            <div class="col-md-2">
                                <label class="form-label mb-1 small">{{ translate('priority') }}</label>
                                <select name="priority" class="form-control form-control-sm">
                                    <option value="">{{ translate('all') }}</option>
                                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>{{ translate('low') }}</option>
                                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>{{ translate('medium') }}</option>
                                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>{{ translate('high') }}</option>
                                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>{{ translate('urgent') }}</option>
                                </select>
                            </div>

                            <!-- Reset Button -->
                            <div class="col-md-2">
                                <a href="{{ route('admin.support-ticket.view') }}" class="btn btn--primary w-100" style="height:35px; padding: 5px 10px 5px 10px;">
                                    <i class="tio-refresh"></i> {{ translate('reset') }}
                                </a>
                            </div>
                            
                            <!-- Show Data Button -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn--primary w-100" style="height:35px; padding: 5px 10px 5px 10px;">
                                    <i class="tio-filter-list"></i> {{ translate('show_data') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="">
                    <div class="px-3 py-4 mb-3 border-bottom">
                        <div class="d-flex flex-wrap justify-content-between gap-3 align-items-center">
                            <div class="">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-merge input-group-custom">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="searchValue"
                                               class="form-control"
                                               placeholder="{{translate('search_ticket_by_subject_or_status').'...'}}"
                                               aria-label="Search orders" value="{{ request('searchValue') }}">
                                        <button type="submit"
                                                class="btn btn--primary">{{translate('search')}}</button>
                                    </div>
                                </form>
                            </div>
                            <div class="">
                                <div class="d-flex flex-wrap flex-sm-nowrap gap-3 justify-content-end">
                                    @php($priority=request()->has('priority')?request()->input('priority'):'')
                                    <select class="form-control border-color-c1 w-160 filter-tickets"
                                            data-value="priority">
                                        <option value="all">{{translate('all_Priority')}}</option>
                                        <option
                                            value="low" {{$priority=='low'?'selected':''}}>{{translate('low')}}</option>
                                        <option
                                            value="medium" {{$priority=='medium'?'selected':''}}>{{translate('medium')}}</option>
                                        <option
                                            value="high" {{$priority=='high'?'selected':''}}>{{translate('high')}}</option>
                                        <option
                                            value="urgent" {{$priority=='urgent'?'selected':''}}>{{translate('urgent')}}</option>
                                    </select>

                                    @php($status=request()->has('status')?request()->input('status'):'')
                                    <select class="form-control border-color-c1 w-160 filter-tickets"
                                            data-value="status">
                                        <option value="all">{{translate('all_Status')}}</option>
                                        <option
                                            value="open" {{$status=='open'?'selected':''}}>{{translate('open')}}</option>
                                        <option
                                            value="close" {{$status=='close'?'selected':''}}>{{translate('close')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($tickets as $key =>$ticket)
                        <div class="border-bottom mb-3 pb-3">
                            <div class="card">
                                <div
                                    class="card-body align-items-center d-flex flex-wrap justify-content-between gap-3 border-bottom">
                                    <div class="media gap-3">
                                        @if($ticket->customer)
                                        <img class="avatar avatar-lg"
                                             src="{{ getStorageImages(path: $ticket->customer->image_full_url??"", type: 'backend-profile') }}"
                                             alt="">
                                        <div class="media-body">
                                            <h6 class="mb-0 {{Session::get('direction') === "rtl" ? 'text-right' : 'text-left'}}">{{$ticket->customer->f_name??""}} {{$ticket->customer->l_name??""}}</h6>
                                            <div
                                                class="mb-2 fz-12 {{Session::get('direction') === "rtl" ? 'text-right' : 'text-left'}}">{{$ticket->customer->email??""}}</div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <span class="badge-soft-danger fz-12 font-weight-bold px-2 radius-50">{{translate(str_replace('_',' ',$ticket->priority))}}</span>
                                                <span class="badge-soft-info fz-12 font-weight-bold px-2 radius-50">{{translate(str_replace('_',' ',$ticket->status))}}</span>
                                                <h6 class="mb-0">{{translate(str_replace('_',' ',$ticket->type))}}</h6>
                                            </div>
                                            <div class="text-nowrap mt-2">
                                                @if ($ticket->created_at->diffInDays(Carbon::now()) < 7)
                                                    {{ date('D h:i:A',strtotime($ticket->created_at)) }}
                                                @else
                                                    {{ date('d M Y h:i:A',strtotime($ticket->created_at)) }}
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                            <h6>{{ translate('customer_not_found').'!' }}</h6>
                                        @endif
                                    </div>

                                    <form action="{{route('admin.support-ticket.status')}}" method="post"
                                          id="support-ticket{{$ticket['id']}}-form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$ticket['id']}}">
                                        <label class="switcher mx-auto">
                                            <input type="checkbox" class="switcher_input toggle-switch-message"
                                                   id="support-ticket{{$ticket['id']}}" name="status"
                                                   value="{{ $ticket['status'] == 'open' ? 'close':'open' }}"
                                                   {{ $ticket['status'] == 'open' ? 'checked':'' }}
                                                   data-modal-id = "toggle-status-modal"
                                                   data-toggle-id = "support-ticket{{$ticket['id']}}"
                                                   data-on-image = "support-ticket-on.png"
                                                   data-off-image = "support-ticket-off.png"
                                                   data-on-title = "{{translate('Want_to_Turn_ON_Support_Ticket_Status').'?'}}"
                                                   data-off-title = "{{translate('Want_to_Turn_OFF_Support_Ticket_Status').'?'}}"
                                                   data-on-message = "<p>{{translate('if_enabled_this_support_ticket_will_be_active')}}</p>"
                                                   data-off-message = "<p>{{translate('if_disabled_this_support_ticket_will_be_inactive')}}</p>">
                                            <span class="switcher_control"></span>
                                        </label>
                                    </form>
                                </div>
                                <div
                                    class="card-body align-items-center d-flex flex-wrap flex-md-nowrap justify-content-between gap-4">
                                    <div>
                                        {{$ticket->description}}
                                    </div>
                                    <div class="text-nowrap">
                                        <a class="btn btn--primary"
                                           href="{{route('admin.support-ticket.singleTicket',$ticket['id'])}}">
                                            <i class="tio-open-in-new"></i> {{translate('view')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="table-responsive mt-4">
                    <div class="px-4 d-flex justify-content-lg-end">
                        {{$tickets->links()}}
                    </div>
                </div>
                @if(count($tickets)==0)
                    @include('layouts.back-end._empty-state',['text'=>'no_support_ticket_found'],['image'=>'default'])
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{dynamicAsset(path: 'public/assets/back-end/js/admin/support-tickets.js')}}"></script>
@endpush
