@if ($items->isEmpty())
    <!-- No Data Available Message -->
    <div class="no-data-message" style="text-align: center; padding: 40px 20px; color: #666;">
        <div style="font-size: 48px; margin-bottom: 20px; color: #ddd;">
            <i class="fas fa-users"></i>
        </div>
        <h3 style="color: #999; margin-bottom: 10px;" class="custom-dealrock-text-30">No Talent Available</h3>
        <p style="color: #666; margin-bottom: 30px; custom-dealrock-text-14">We couldn't find any talent profiles matching your criteria. Try adjusting your filters or check back later.</p>
    </div>

    <!-- Sample Data Card -->
    <div class="job-card sample-card" style="opacity: 0.7; border: 2px dashed #ddd; background: #f9f9f9;">
        <div class="job-header">
            <div class="job-title-location">
                <h3>Senior Software Developer <span style="color: #999; font-size: 14px; font-weight: normal;">(Sample Profile)</span></h3>
                <p>New York, United States</p>
            </div>
        </div>

        <div class="job-details">
            <div class="job-experience">
                <div class="experience-item">
                    <h4>Google Inc.</h4>
                    <p>Senior Software Engineer - 3 years experience in full-stack development</p>
                    <h4>Microsoft Corporation</h4>
                    <p>Software Developer - 2 years experience in cloud technologies</p>
                </div>
            </div>

            <div class="job-education-skills">
                <div class="education">
                    <h4>Education</h4>
                    <p>Master's in Computer Science, Stanford University</p>
                </div>
                <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">Node.js</span>
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">AWS</span>
                    </div>
                </div>
            </div>

            <div class="job-meta">
                <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>5 Years</p>
                </div>
                <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>United States</p>
                </div>
            </div>

            <div class="job-actions col-auto align-self-center p-4">
                <button type="button" class="message-btn" disabled style="opacity: 0.5; cursor: not-allowed;">Sample Profile</button>
            </div>
        </div>
    </div>
@else
    @foreach ($items as $item)
    <div class="job-card">
        <div class="job-header">
            <div class="job-title-location">
                <h3>{{ $item->desired_position ?? 'Position Not Specified' }}</h3>
                <p>
                    @php
                        $cityName = 'Unknown City';
                        $countryName = 'Unknown Country';
                        
                        if ($item->city) {
                            $city = \App\Models\City::find($item->city);
                            $cityName = $city ? $city->name : 'Unknown City';
                        }
                        
                        if ($item->country) {
                            $country = \App\Models\Country::find($item->country);
                            $countryName = $country ? $country->name : 'Unknown Country';
                        }
                    @endphp
                    {{ $cityName }}, {{ $countryName }}
                </p>
            </div>
        </div>

        <div class="job-details">
            <div class="job-experience">
                <div class="experience-item">
                    @if (!empty($item->previous_employers))
                        @php
                            $employers = [];
                            try {
                                $employers = json_decode($item->previous_employers, true);
                                if (json_last_error() !== JSON_ERROR_NONE || !is_array($employers)) {
                                    $employers = [];
                                }
                            } catch (\Exception $e) {
                                $employers = [];
                            }
                        @endphp
                        
                        @if (!empty($employers))
                            @foreach ($employers as $employer)
                                @php
                                    // Safely separate by " - " to get company and rest
                                    $parts = explode(' - ', $employer, 2);
                                    $company = trim($parts[0] ?? '');
                                    $details = trim($parts[1] ?? '');
                                @endphp
                                @if (!empty($company))
                                    <h4>{{ $company }}</h4>
                                    @if (!empty($details))
                                        <p>{{ $details }}</p>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <p>No previous employment information available</p>
                        @endif
                    @else
                        <p>No previous employment information available</p>
                    @endif
                </div>
            </div>

            <div class="job-education-skills">
                <div class="education">
                    <h4>Education</h4>
                    <p>
                        @if (!empty($item->highest_education) || !empty($item->university_name))
                            {{ $item->highest_education ?? 'Not specified' }}
                            @if (!empty($item->university_name))
                                , {{ $item->university_name }}
                            @endif
                        @else
                            Education information not available
                        @endif
                    </p>
                </div>
                <div class="skills">
                    <h4>Skills</h4>
                    <div class="skill-tags">
                        @if (!empty($item->skills))
                            @php
                                $skills = [];
                                try {
                                    $skills = json_decode($item->skills, true);
                                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($skills)) {
                                        // Fallback: treat as comma-separated string
                                        $skills = explode(',', str_replace(['[', ']', '"'], '', $item->skills));
                                    }
                                } catch (\Exception $e) {
                                    $skills = [];
                                }
                            @endphp
                            
                            @if (!empty($skills))
                                @foreach ($skills as $skill)
                                    @php $skill = trim($skill); @endphp
                                    @if (!empty($skill))
                                        <span class="skill-tag">{{ $skill }}</span>
                                    @endif
                                @endforeach
                            @else
                                <span class="skill-tag">No skills listed</span>
                            @endif
                        @else
                            <span class="skill-tag">No skills listed</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="job-meta">
                <div class="experience-total">
                    <h4>Total Experience</h4>
                    <p>{{ $item->years_of_experience ?? 0 }} Years</p>
                </div>
                <div class="job-location">
                    <h4>Current Job Location</h4>
                    <p>{{ $countryName }}</p>
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
                                <div class="supplier-name-field">{{ $item->full_name ?? 'Unknown User' }}</div>
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
@endif
