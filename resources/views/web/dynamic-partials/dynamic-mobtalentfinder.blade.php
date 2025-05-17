@foreach ($items as $item)
    <div class="user-card-mobile">
        <div class="card-mobile">
            <div class="card-header-mobile">
                <div>
                    <h6 class="title-mobile">{{ $item->desired_postion }}</h6>
                    <p class="location-mobile">{{ \App\Models\City::find($item->city)->name }},
                        {{ \App\Models\Country::find($item->country)->name }}</p>
                </div>
                <div class="skills-mobile">
                    <h3><strong>Skills</strong></h3><br>
                    @foreach (json_decode($item->skills, true) as $skill)
                        <span class="skill-tag">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>
            <div class="card-body-2">
                <div class="card-body-mobile">

                    <h5><strong>Total Experience</strong></h5>
                    <p>{{ $item->years_of_experience }} Years</p>

                </div>
                <div class="card-body-mobile">
                    <h5> <strong>Current Job Location </strong></h5>
                    <p>{{ \App\Models\Country::find($item->country)->name }}</p>
                </div>

            </div>
            <div class="card-body-mobile">
                <h5><strong>Education</strong></h5>
                <p>{{ $item->highest_education }}, {{ $item->university_name }}</p>

            </div>
            <div class="card-footer-mobile">
                <button class="btn-mobile">Message</button>
            </div>
        </div>
    </div>
@endforeach
