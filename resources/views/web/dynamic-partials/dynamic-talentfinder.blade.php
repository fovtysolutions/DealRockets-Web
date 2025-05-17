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
                <button type="button" class="message-btn">Message</button>
            </div>
        </div>
    </div>
@endforeach
