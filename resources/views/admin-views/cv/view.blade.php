@extends('layouts.back-end.app-partial')

@section('title', translate('View_cv'))

@push('css_or_js')
    <link href="{{ dynamicAsset('public/assets/back-end/css/tags-input.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ dynamicAsset('public/assets/back-end/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset('public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('View_cv') }}
        </h2>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>{{ translate('cv_Details') }}</h4>

            <div class="mb-3">
                <strong>{{ translate('cv Name') }}:</strong> {{ $cv->name }}
            </div>

            <div class="mb-3">
                <strong>{{ translate('Details') }}:</strong> {{ $cv->details }}
            </div>

            <div class="mb-3">
                <strong>{{ translate('Email') }}:</strong> {{ $cv->email }}
            </div>

            <div class="mb-3">
                <strong>{{ translate('Phone Number') }}:</strong> {{ $cv->pnumber }}
            </div>

            <!-- Display File Attachment -->
            <div class="mb-3">
                <strong>{{ translate('Documents') }}:</strong>
                <div class="d-flex flex-wrap">
                    @if ($cv->image_path)
                        @php
                            $filePath = storage_path('app/public/' . $cv->image_path); // File path
                            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION); // Get the file extension
                        @endphp

                        @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                            <!-- Image Files -->
                            <div class="me-3 mb-3">
                                <img src="{{ asset('/storage/' . $cv->image_path) }}"
                                    class="img-thumbnail" alt="File Image">
                            </div>
                        @elseif (strtolower($fileExtension) == 'pdf')
                            <!-- PDF Files -->
                            <div class="me-3 mb-3">
                                <a href="{{ asset('/storage/' . $cv->image_path) }}" target="_blank"
                                    class="btn btn-outline-info">
                                    <i class="tio-file-pdf"></i> {{ translate('View PDF') }}
                                </a>
                            </div>
                        @elseif (strtolower($fileExtension) == 'docx')
                            <!-- DOCX Files -->
                            <div class="me-3 mb-3">
                                <a href="{{ route('admin.convert-docx-to-pdf', ['file' => $cv->image_path]) }}" target="_blank"
                                    class="btn btn-outline-info">
                                    <i class="tio-file-word"></i> {{ translate('View DOCX') }}
                                </a>
                            </div>
                        @else
                            <!-- Other File Types (fallback) -->
                            <div class="me-3 mb-3">
                                <a href="{{ asset('/storage/' . $cv->image_path) }}" download class="btn btn-outline-secondary">
                                    <i class="tio-download"></i> {{ translate('Download File') }}
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div class="row justify-content-end gap-3 mt-3 mx-1">
        <a href="{{ route('admin.cv.edit', $cv->id) }}" class="btn btn--primary px-5">{{ translate('Edit') }}</a>
        <a href="{{ route('admin.cv.list') }}" class="btn btn-secondary px-5">{{ translate('Back to List') }}</a>
    </div>
</div>
@endsection