<section class="mainpagesection" style="gap: 20px;display: flex;flex-direction: column; background-color: var(--web-bg) !important;">
@if (!empty($homepagesetting[0]['products']))
    @include('web-views.partials._genresection')
@endif
@if (!empty($homepagesetting[0]['products']))
    @include('web-views.partials._genresection1')
@endif
@if (!empty($homepagesetting[0]['products']))
    @include('web-views.partials._genresection2')
@endif
@if (!empty($homepagesetting[0]['products']))
    @include('web-views.partials._genresection3')
@endif
</section>
<script defer>
    document.addEventListener("DOMContentLoaded", function () {
        console.log("Window width:", window.innerWidth);

        const titles = document.querySelectorAll(".mainpagesection .title");

        titles.forEach(title => {
            const words = title.textContent.trim().split(" ");
            
            // Only modify on mobile
            title.innerHTML = words.map(word => 
                `<span style="text-shadow: 2px 2px 4px rgba(0,0,0,0.6); margin-right: 5px;">${word}</span>`
            ).join(" ");
        });
    });
</script>