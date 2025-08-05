@extends('layouts.back-end.app-partial')

@section('title', translate('Registered Candidates'))

@push('css_or_js')
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Registered Candidates') }}
                <span class="badge badge-soft-dark radius-50 fz-14 ml-1">{{ $candidates->total() ?? count($candidates) }}</span>
            </h2>
        </div> -->

        <div class="container-fluid p-0">
            <div class="mb-3">
                <div class="card-body p-0">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-2 col-sm-4 col-6">
                                <label class="form-label mb-1 small">{{ translate('search') }}</label>
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ translate('search_by_name_or_email') }}" value="{{ request('search') }}">
                            </div>

                            <div>
                                <a href="{{ route('admin.jobvacancy.registered-candidates') }}"
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

        <div>
            <div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translate('Registered Candidates List') }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>City</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($candidates as $candidate)
                                        <tr>
                                            <td>{{ $candidate->id }}</td>
                                            <td>{{ $candidate->full_name }}</td>
                                            <td>{{ $candidate->email }}</td>
                                            <td>{{ $candidate->phone }}</td>
                                            <td>{{ \App\Utils\ChatManager::getCityName($candidate->city) ?? 'N/A' }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#viewModal{{ $candidate->id }}">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="viewModal{{ $candidate->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewModalLabel{{ $candidate->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $candidate->id }}">
                                                            Candidate Details</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Full Name:</strong> {{ $candidate->full_name }}</p>
                                                        <p><strong>Email:</strong> {{ $candidate->email }}</p>
                                                        <p><strong>Phone:</strong> {{ $candidate->phone }}</p>
                                                        <p><strong>City:</strong> {{ \App\Utils\ChatManager::getCityName($candidate->city) ?? 'N/A' }}</p>
                                                        <p><strong>State:</strong> {{ \App\Utils\ChatManager::getStateName($candidate->state) ?? 'N/A' }}</p>
                                                        <p><strong>Country:</strong> {{ \App\Utils\ChatManager::getCountryDetails($candidate->country)['countryName'] ?? 'N/A' }}</p>
                                                        <p><strong>Highest Education:</strong> {{ $candidate->highest_education ?? 'N/A' }}</p>
                                                        <p><strong>Skills:</strong> {{ implode(', ', json_decode($candidate->skills ?? '[]')) }}</p>
                                                        <p><strong>Resume:</strong> 
                                                            @if ($candidate->resume)
                                                                <a href="{{ asset($candidate->resume) }}" target="_blank">View Resume</a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            {{ $candidates->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/tags-input.min.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/spartan-multi-image-picker.js') }}"></script>
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/plugins/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#filterRegisteredCandidates-form').on('submit', function (e) {
                e.preventDefault();
                var search = $('#search').val();
                var url = "{{ route('admin.jobvacancy.registered-candidates') }}?search=" + search;
                window.location.href = url;
            });
            $('#search').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    $('#filterRegisteredCandidates-form').submit();
                }
            });
            $('#search').on('change', function (e) {
                $('#filterRegisteredCandidates-form').submit();
            });
            $('#search').on('input', function (e) {
                if ($(this).val() === '') {
                    $('#filterRegisteredCandidates-form').submit();
                }
            });
        });
    </script>
@endpush