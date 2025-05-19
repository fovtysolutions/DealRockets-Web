@foreach ($jobseeker as $item)
    <div class="job-card" data-id="{{ $item->id }}" onclick="populateDetailedBox(this)">
        <div class="job-header">
            <h2>{{ $item->title ?? 'Untitled Position' }}</h2>
            <p class="job-meta">
                {{ optional($item->created_at)->diffForHumans() ?? 'Date not available' }} 
                by {{ $item->company_name ?? 'Unknown Company' }}
            </p>
        </div>
        <div class="job-details">
            <div style="display: flex; justify-content: space-between;">
                <div class="job-info">
                    <div class="salary">
                        <i class="fa-sharp fa-solid fa-dollar-sign"></i> 
                        {{ $item->salary_low ?? 'N/A' }} to {{ $item->salary_high ?? 'N/A' }}
                    </div>

                    <div class="location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ optional(\App\Models\City::find($item->city))->name ?? 'Unknown Location' }}
                    </div>

                    <div class="type">
                        <i class="fa-sharp fa-solid fa-house"></i> 
                        {{ $item->employment_space ?? 'Not specified' }}
                    </div>

                    <div class="commitment">
                        <i class="fas fa-clock"></i> 
                        {{ $item->employment_type ?? 'Not specified' }}
                    </div>
                </div>
            </div>

            <div class="job-description">
                <p>{{ $item->description ?? 'No description provided.' }}</p>
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
