@foreach ($items as $item)
    <div class="job-card">
        <div class="job-header">
            <div class="job-title-location">
                <h3>{{ $item->desired_position }}</h3>
                <p>{{ \App\Models\City::find($item->city)->name }},
                    {{ \App\Models\Country::find($item->country)->name }}</p>
            </div>
        </div>

        <div class="job-details">
            <div class="job-experience">
                <div class="experience-item">
                    @foreach (json_decode($item->previous_employers, true) as $employer)
                        @php
                            // Separate by " - " to get company and rest
                            [$company, $details] = explode(' - ', $employer, 2);
                        @endphp
                        <h4>{{ trim($company) }}</h4>
                        <p>{{ trim($details) }}</p>
                    @endforeach
                </div>
            </div>


            <div class="job-education-skills">
                <div class="education">
                    <h4>Education</h4>
                    <p>{{ $item->highest_education }}, {{ $item->university_name }}</p>
                </div>
                <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                        @foreach (json_decode($item->skills, true) as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="job-meta">
                <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>{{ $item->years_of_experience }} Years</p>
                </div>
                <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>{{ \App\Models\Country::find($item->country)->name }}</p>
                </div>
            </div>

            <div class="job-actions col-auto align-self-center p-4">
                <button type="button" data-toggle="modal" data-target="#inquireButton{{ $item->id }}" class="message-btn">Message</button>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="inquireButton{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="inquireButtonLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="inquiry-form">
                    <div class="inquiry-header">
                        Send a direct inquiry to this supplier
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="margin: auto !important;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="inquiry-body">
                        <form id="inquiryForm">
                            @csrf
                            @php
                                $userdata = \App\Utils\ChatManager::getRoleDetail();
                                $userId = $userdata['user_id'] ?? null;
                                $role = $userdata['role'] ?? null;
                            @endphp
                            <!-- Hidden fields -->
                            <input type="hidden" id="sender_id" name="sender_id" value={{ $userId }}>
                            <input type="hidden" id="sender_type" name="sender_type" value={{ $role }}>
                            <input type="hidden" id="receiver_id" name="receiver_id" value={{ $item->user_id }}>
                            <input type="hidden" id="receiver_type" name="receiver_type" value='customer'>
                            <input type="hidden" id="type" name="type" value="reachout">

                            <!-- Visible fields -->
                            <div class="form-group">
                                <label for="supplier">To</label>
                                <div class="supplier-name-field">{{ $item->full_name }}</div>
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea id="message" name="message"
                                    placeholder="Enter a Reach Out Message" rows="6"
                                    required></textarea>
                            </div>
                            @if (auth('customer')->check() && auth('customer')->user()->id)
                                @if ($membership['status'] == 'active')
                                    <button type="button" onclick="triggerChat()" class="btn-inquire-now">Send Inquiry Now</button>
                                @else
                                    <button href="{{ route('membership') }}" class="btn-inquire-now">Send Inquiry
                                        Now</button>
                                @endif
                            @else
                                <button href="#" onclick="sendtologin()" class="btn-inquire-now">Send Inquiry
                                    Now</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
