<?php
// Dynamic values
$nameQuote = "Submit CV";
$keyword = "Your name";
$description = "Your Details";
$inputType = "file";
$quantity = ""; // You can set this based on your form logic.
    ?>
<section class="fade-in-on-scroll">
    <div class="quotation-sec" id="sendcv" style="background-image: linear-gradient(to bottom right, rgba(0, 0, 0, 0.6), rgba(45, 0, 0, 0.33)), url('/images/mp/cvsourcing.jpg');height: 430px; box-shadow: none;background-size: contain;background-position: center;">
        <div class="quotation-txt">
            <h2>CV Sourcing</h2>
            <p class="mb-4">An easy way to post your Job openings and grow business.</p>
            <p class="mb-4">
                Browse Jobs
                <br />
                Find Potential Recruits
                <br />
                All in Same Place
            </p>
            <div>
                <a id="industryjobs" href="{{ route('sendcv') }}">Check Interest <span>&#8250;</span></a>
            </div>
        </div>
        <div class="quotation-form">
            <form id="cvForm" action="{{ route('cvpublic') }}" method="POST">
                <h2 class="title-form-qut"><?php echo $nameQuote; ?></h2>
                <div class="mb-3">
                    <input type="text" class="form-control" id="Name" name="name" required
                    placeholder="<?php echo $keyword; ?>" />
                </div>

                <div class="mb-3">
                    <textarea class="form-control" id="detail" name="details" rows="3" required
                        placeholder="<?php echo $description; ?>"></textarea>
                </div>

                <div class="mb-3">
                    <input type="<?php echo $inputType; ?>" class="form-control" id="cv" style="padding: .375rem .75rem;"
                        name="cv" required />
                </div>
                <!-- Temporary Measure -->
                @if (auth('customer')->check())
                    <button type="submit" class="btn">
                        Submit CV Now
                    </button>
                @else
                    <a href="{{ route('customer.auth.login') }}" class="btn">
                        Submit CV Now
                    </a>
                @endif
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#cvForm').on('submit', function (event) {
                event.preventDefault(); // Prevent default form submission

                // Create a FormData object to hold file data
                var formData = new FormData(this);

                $.ajax({
                    url: {{ route('cvpublic')}}, // Laravel route
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function (response) {
                        alert('CV submitted successfully!');
                        // Optionally redirect or reset form
                        $('#cvForm')[0].reset();
                    },
                    error: function (xhr, status, error) {
                        alert('Error submitting CV');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</section>