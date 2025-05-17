    @foreach ($jobseeker as $item)
        <div class="job-card" data-id="{{ $item->id }}" onclick="populateDetailedBox(this)">
            <div class="job-header">
                <h2>{{ $item->title }}</h2>
                <p class="job-meta">{{ $item->created_at->diffForHumans() }} by {{ $item->company_name }}</p>
            </div>
            <div class="job-details">
                <div class="" style="display: flex; justify-content: space-between;">
                    <div class="job-info">
                        <div class="salary"><i class="fa-sharp fa-solid fa-dollar-sign"></i> {{ $item->salary_low }} to
                            {{ $item->salary_high }}</div>
                        <div class="location"><i class="fas fa-map-marker-alt"></i>
                            {{ \App\Models\City::where('id', $item->city)->first()->name }}</div>
                        <div class="type"><i class="fa-sharp fa-solid fa-house"></i> {{ $item->employment_space }}
                        </div>
                        <div class="commitment"><i class="fas fa-clock"></i> {{ $item->employment_type }}</div>
                    </div>
                    {{-- <div>
                        <button class="apply-btn">Apply Now</button>
                    </div> --}}

                </div>

                <div class="job-description">
                    <p>{{ $item->description }}</p>
                </div>

            </div>
        </div>
    @endforeach
<script>
    function populateDetailedBox(card) {
        var id = $(card).data("id");
        if (window.innerWidth < 768) {
            toggleDetailBox(); // Show modal or detail box
        }
        loadVacancyData(id);
    }

    function toggleDetailBox() {
        const $box = $("#dynamicvacanciesviews");

        if ($box.is(":hidden")) {
            $box.css({
                display: "block",
                position: "fixed",
                zIndex: 10000,
                top: "24px",
                width: "90vw",
                height: "90vh",
                maxWidth: "unset",
                left: "50%",
                transform: "translateX(-50%)",
                overflowY: "auto",
                backgroundColor: "#fff", // Optional: add background if content is transparent
                boxShadow: "0 0 10px rgba(0,0,0,0.2)", // Optional for modal effect
                borderRadius: "10px" // Optional for aesthetics
            });
        } else {
            $box.css("display", "none");
        }
    }

    function loadVacancyData(id) {
        $("#dynamicLoader").css("display", "block");

        $.ajax({
            url: "{{ route('dynamic-jobview') }}",
            method: "GET",
            data: {
                id: id
            },
            success: function(response) {
                $("#dynamicvacanciesviews").html(response.html);
                $("#dynamicLoader").css("display", "none");
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                $("#dynamicLoader").css("display", "none");
            }
        });
    }
</script>
