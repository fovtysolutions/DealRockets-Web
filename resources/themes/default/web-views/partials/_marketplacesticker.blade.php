{{-- <div style="background-image: url('{{ asset('storage/'. $marketplacedata)}}');background-size: cover;background-position: center;height: 420px;"> --}}
<div>
    <div class="row align-items-center">
        <!-- Left side: gif -->
        <div class="col-md-6 text-left slide-left">
            <img src="/images/cxanimation_final_novo_nologos-01.gif" alt="Your GIF" class="img-fluid"/>
        </div>

        <!-- Right side: text -->
        <div class="col-md-6 text-right slide-right">
            <h4 class="lead mb-0">Source your product from global marketplace 10000+ products from varied suppliers</h4>
        </div>
    </div>
</div>

<!-- Add CSS for animations and styling -->
<style>
    .lead {
        /* font-size: 1.5rem; */
        /* font-weight: 600; */
    }

    .slide-left {
        opacity: 0;
        transform: translateX(-50px);
        animation: slideInLeft 1s forwards;
    }

    .slide-right {
        opacity: 0;
        transform: translateX(50px);
        animation: slideInRight 1s forwards;
    }

    @keyframes slideInLeft {
        0% {
            opacity: 0;
            transform: translateX(-50px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        0% {
            opacity: 0;
            transform: translateX(50px);
        }
        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
