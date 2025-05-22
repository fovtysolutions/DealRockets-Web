<div class="bg-white w-full sticky top-0 flex py-2 px-4 text-gray-600 text-[0.7rem] justify-between">
    <div class="flex gap-1">
        <div class="flex gap-1">
            <input class="py-auto px-2" type="checkbox" name="select" id="select">
            <button class="grid place-content-center rounded-full hover:bg-gray-200  text-gray-700 px-1 h-full"><i
                    class="fa-solid fa-caret-down"></i></button>
        </div>
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                class="fa-solid fa-rotate-right"></i></button>
    </div>
    <div class="flex gap-1">
        <div class="flex items-center h-full rounded-md px-2 cursor-pointer hover:bg-gray-200">
            <p>1-50 of 4,814</p>
        </div>
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                class="fa-solid fa-chevron-left"></i></button>
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>
<div class="scrolable-width overflow-y-scroll overflow-x-hidden">
    <div class="hidden md:flex h-12 text-sm font-medium leading-none text-gray-600 border-b border-gray-200">
        <button data-tab="rfq"
            class="tab-button active-tab flex h-full w-52 items-center px-4 gap-4 text-blue-600 border-b-[3px] border-blue-600">
            <i class="fa-solid fa-inbox"></i>
            <p>RFQ</p>
        </button>
        <button data-tab="sell" class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
            <i class="fa-solid fa-receipt"></i>
            <p>Sell Offer</p>
        </button>
        <button data-tab="stock" class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
            <i class="fa-solid fa-receipt"></i>
            <p>Stock Sale</p>
        </button>
        <button data-tab="market" class="tab-button flex h-full w-52 items-center px-4 gap-4 hover:bg-gray-200">
            <i class="fa-solid fa-receipt"></i>
            <p>Marketplace</p>
        </button>
    </div>
    <div class="tab-content-wrapper flex flex-col h-full">
        <div id="tab-rfq" class="tab-content">
            @include('admin-views.betterchat.partials.rfqentries', ['chatdata' => $chatData['buyleads'] ?? []])
        </div>
        <div id="tab-sell" class="tab-content hidden">
            @include('admin-views.betterchat.partials.saleofferentries', [
                'chatdata' => $chatData['sellleads'] ?? [],
            ])
        </div>
        <div id="tab-stock" class="tab-content hidden">
            @include('admin-views.betterchat.partials.stocksaleentries', [
                'chatdata' => $chatData['stocksell'] ?? [],
            ])
        </div>
        <div id="tab-market" class="tab-content hidden">
            @include('admin-views.betterchat.partials.marketplaceentries', [
                'chatdata' => $chatData['products'] ?? [],
            ])
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.tab-button').on('click', function () {
            const tabId = $(this).data('tab');

            // Remove active style from all buttons
            $('.tab-button').removeClass('active-tab text-blue-600 border-blue-600 border-b-[3px]');

            // Add active style to clicked button
            $(this).addClass('active-tab text-blue-600 border-blue-600 border-b-[3px]');

            // Hide all tab contents
            $('.tab-content').addClass('hidden');

            // Show the matching tab
            $('#tab-' + tabId).removeClass('hidden');
        });
    });
</script>
