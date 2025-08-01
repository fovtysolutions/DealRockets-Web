@if ($items->isEmpty())
    <!-- No Data Available Message for Mobile -->
    <div class="no-data-message-mobile" style="text-align: center; padding: 40px 20px; color: #666;">
        <div style="font-size: 48px; margin-bottom: 20px; color: #ddd;">
            <i class="fas fa-users"></i>
        </div>
        <h3 style="color: #999; margin-bottom: 10px;">No Talent Available</h3>
        <p style="color: #666; margin-bottom: 30px;">We couldn't find any talent profiles matching your criteria. Try adjusting your filters or check back later.</p>
    </div>
@else
    @foreach ($items as $item)
        <div class="user-card-mobile">
            <div class="card-mobile">
                <div class="card-header-mobile">
                    <div>
                        <h6 class="title-mobile">{{ $item->desired_position ?? 'Position Not Specified' }}</h6>
                        <p class="location-mobile">
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
                    <div class="skills-mobile">
                        <h3><strong>Skills</strong></h3><br>
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
                <div class="card-body-2">
                    <div class="card-body-mobile">
                        <h5><strong>Total Experience</strong></h5>
                        <p>{{ $item->years_of_experience ?? 0 }} Years</p>
                    </div>
                    <div class="card-body-mobile">
                        <h5><strong>Current Job Location</strong></h5>
                        <p>{{ $countryName }}</p>
                    </div>
                </div>
                <div class="card-body-mobile">
                    <h5><strong>Education</strong></h5>
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
                <div class="card-footer-mobile">
                    <button class="btn-mobile" data-toggle="modal" data-target="#inquireButton{{ $item->id }}">Message</button>
                </div>
            </div>
        </div>
    @endforeach
@endif
