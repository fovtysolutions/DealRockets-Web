<?php
$termsandconditions = App\Models\BusinessSetting::where('type', 'terms_condition')->first()->value;
$privacypolicy = App\Models\BusinessSetting::where('type', 'privacy_policy')->first()->value;
?>

<!-- Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" aria-labelledby="policyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="policyModalLabel">Terms & Privacy Policy</h5>
            </div>
            <div class="modal-body">
                <div>
                    <h4>Terms and Conditions</h4>
                    <p><?php echo $termsandconditions ?? 'Terms and conditions not available.'; ?></p>
                </div>
                <hr>
                <div>
                    <h4>Privacy Policy</h4>
                    <p><?php echo $privacypolicy ?? 'Privacy policy not available.'; ?></p>
                </div>
            </div>
            @if(auth('customer')->check())
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mr-4" data-bs-dismiss="modal"
                        id="acceptButton">Accept</button>
                    <button type="button" class="btn btn-danger" id="declineButton">Decline</button>
                </div>
                <script>
                    $(document).ready(function() {
                        console.log('policyModal');
                        
                        var policyModal = new bootstrap.Modal($('#policyModal')[0]);
                        var termsAccepted = false;  // Flag to track if terms are accepted
                
                        // Automatically show the modal when the page loads
                        // policyModal.show();
                
                        // Redirect to home page when "Decline" button is clicked
                        $('#declineButton').on('click', function() {
                            window.location.href = '/'; // Adjust this path if your home page URL is different
                        });
                
                        // Handle "Accept" button click
                        $('#acceptButton').on('click', function() {
                            $.ajax({
                                method: 'POST',
                                url: "{{ route('acceptterms') }}",
                                data: {
                                    user: "{{ auth('customer')->user()->id }}",
                                },
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                success: function(response) {
                                    console.log('Terms accepted:', response);
                                    termsAccepted = true;  // Set flag to true
                                    policyModal.hide();  // Hide the modal after acceptance
                                    
                                    // Optionally, you can redirect or show a success message
                                    // window.location.href = "/dashboard"; // Example redirect
                                },
                                error: function(error) {
                                    console.error('Error accepting terms:', error);
                                    alert('An error occurred while accepting terms. Please try again.');
                                }
                            });
                        });
                
                        // Check if terms are accepted when the modal is closed
                        $('#policyModal').on('hidden.bs.modal', function() {
                            if (termsAccepted) {
                                console.log('Terms accepted, no action.');
                            } else {
                                console.log('Terms not accepted, redirecting...');
                                window.location.href = '/';  // Redirect to home page if not accepted
                            }
                        });
                    });
                </script>                
            @else
                <div class="modal-footer">
                    <a class="btn btn-primary mr-4" data-bs-dismiss="modal"
                        id="acceptButton" href="{{ route('customer.auth.login')}}">Accept</a>
                    <a class="btn btn-danger" id="declineButton" href="{{ route('customer.auth.login')}}">Decline</a>
                </div>
                <script>
                    $(document).ready(function() {
                        console.log('policyModal');
                        
                        var policyModal = new bootstrap.Modal($('#policyModal')[0]);
                        var termsAccepted = false;  // Flag to track if terms are accepted
                
                        // Automatically show the modal when the page loads
                        // policyModal.show();
                
                        // Check if terms are accepted when the modal is closed
                        $('#policyModal').on('hidden.bs.modal', function() {
                            if (termsAccepted) {
                                console.log('Terms accepted, no action.');
                            } else {
                                console.log('Terms not accepted, redirecting...');
                                // window.location.href = '/customer/auth/login';
                            }
                        });
                    });
                </script>
            @endif
        </div>
    </div>
</div>
