@extends('layouts.front-end.app')
@section('title',translate('Quotation'. ' | ' . $web_config['name']->value))
@section('content')
<div class="mainpagesection" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold text-white">Request for Quotation</h1>
            <p class="lead text-white">Fill out the form below and we'll get back to you with a quotation!</p>
        </div>

        <!-- RFQ Form Section -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('quotation.submit') }}">
                            @csrf

                            <!-- Name Input -->
                            <div class="mb-4">
                                <label for="name" class="form-label text-muted">Full Name</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name"
                                    placeholder="Enter your full name" required>
                            </div>

                            <!-- Description Input -->
                            <div class="mb-4">
                                <label for="description" class="form-label text-muted">Description of Product/Service</label>
                                <textarea class="form-control form-control-lg" id="description" name="description" rows="5"
                                    placeholder="Please describe the product or service you're looking for" required></textarea>
                            </div>

                            <!-- Quantity Input -->
                            <div class="mb-4">
                                <label for="quantity" class="form-label text-muted">Quantity</label>
                                <input type="number" class="form-control form-control-lg" id="quantity" name="quantity"
                                    placeholder="Enter the quantity needed" min="1" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100 py-3">Submit RFQ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
