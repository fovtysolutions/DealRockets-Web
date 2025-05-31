@extends('layouts.back-end.app-partialseller')

@section('title', translate('Manage FAQ'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/inhouse-product-list.png') }}" alt="">
                {{ translate('Manage FAQ') }}
            </h2>
        </div>

        <div class="row mt-20">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table id="datatable"
                            class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ translate('SL') }}</th>
                                    <th>{{ translate('Question') }}</th>
                                    <th>{{ translate('Answer') }}</th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $key => $faq)
                                    <tr>
                                        <td scope="row">{{ $key + 1 }}</td>
                                        <td>
                                            {{ $faq['question'] }}
                                        </td>
                                        <td>
                                            {{ $faq['answer'] }}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-outline--primary btn-sm square-btn edit-faq"
                                                    data-id="{{ $faq->id }}" data-question="{{ $faq->question }}"
                                                    data-answer="{{ $faq->answer }}">
                                                    <i class="tio-edit"></i>
                                                </button>

                                                <button class="btn btn-outline-danger btn-sm square-btn delete-faq"
                                                    data-id="{{ $faq->id }}">
                                                    <i class="tio-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editfaqform">
                @csrf
                <input type="hidden" id="edit_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFaqLabel">Edit FAQ</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal">X</button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Question</label>
                            <input type="text" id="edit_question" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Answer</label>
                            <textarea id="edit_answer" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Edit Button Click
        $(document).on('click', '.edit-faq', function() {
            let id = $(this).data('id');
            let question = $(this).data('question');
            let answer = $(this).data('answer');

            $('#edit_id').val(id);
            $('#edit_question').val(question);
            $('#edit_answer').val(answer);
            $('#editFaqModal').modal('show');
        });

        // Handle Update Form Submit
        $('#editfaqform').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('vendor.crudfaq') }}',
                method: 'POST',
                data: {
                    action: 'update',
                    id: $('#edit_id').val(),
                    question: $('#edit_question').val(),
                    answer: $('#edit_answer').val(),
                    seller: '{{ auth('seller')->id() }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    toastr.success('FAQ updated successfully');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Update failed');
                    console.error(xhr.responseText);
                }
            });
        });

        // Delete FAQ
        $(document).on('click', '.delete-faq', function() {
            if (!confirm('Are you sure you want to delete this FAQ?')) return;
            let id = $(this).data('id');

            $.ajax({
                url: '{{ route('vendor.crudfaq') }}',
                method: 'POST',
                data: {
                    action: 'delete',
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    toastr.success('FAQ deleted');
                    location.reload();
                },
                error: function(xhr) {
                    toastr.error('Delete failed');
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endpush
