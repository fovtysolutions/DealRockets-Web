@extends('layouts.back-end.app-partialseller')

@section('title', translate('Create FAQ'))

@section('content')
<div class="content container-fluid">
    <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
            {{ translate('Add New FAQ') }}
        </h2>
    </div>

    <form class="product-form text-start" id="createfaq">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <label class="title-color">Question</label>
                        <input class="form-control" type="text" name="question" id="question">
                    </div>
                    <div class="col-lg-12">
                        <label class="title-color">Answer</label>
                        <input class="form-control" type="text" name="answer" id="answer">
                    </div>
                    <input type="hidden" name="seller" id="seller" value={{ auth('seller')->user()->id }}>
                </div>
                <div class="row justify-content-end gap-3 mt-3 mx-1">
                    <button type="submit" class="btn btn--primary px-5">{{ translate('submit') }}</button>
                </div>
            </div>    
        </div>
    </form>
</div>
@endsection

@push('script')
<script>
    var createfaqform = document.getElementById('createfaq');

    createfaqform.addEventListener('submit',function(e){
        e.preventDefault();

        var question = document.getElementById('question').value;
        var answer = document.getElementById('answer').value;
        var seller = document.getElementById('seller').value;

        $.ajax({
            url:'{{ route("vendor.crudfaq") }}',
            method: 'POST',
            data: {
                action: 'create',
                question: question,
                answer: answer,
                seller: seller,
                _token: '{{ csrf_token() }}',
            },
            success: function(){
                toastr.success('FAQ Created Successfully');
                window.location.href = '{{ route("vendor.managefaq") }}';
            },
            error: function(){
                toastr.error('FAQ Fail');
                console.error(xhr.responseText);
            }
        });
    }); 
</script>
@endpush