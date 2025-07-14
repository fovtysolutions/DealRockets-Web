@if ($chatdata->isEmpty())
    <div class="p-4 text-gray-500 text-sm">
        No messages found in this category.
    </div>
@else
    <div class="divide-y divide-gray-200">
        @foreach ($chatdata as $item)
            @php
                $isNotification = $item['category'] === 'notification';
                $isRead = $item['is_read'] == 1;
                $chatUser = \App\Utils\ChatManager::getUserDataChat($item['sender_id'], $item['sender_type']);
                $targetUser = \App\Utils\ChatManager::getUserDataChat($item['receiver_id'], $item['receiver_type']);
                $listingId = match ($item['type']) {
                    'stocksell' => $item['stocksell_id'],
                    'sellleads', 'buyleads' => $item['leads_id'],
                    'products', 'marketplace' => $item['product_id'],
                    default => null,
                };
                $type = $item['type'];
                // Dynamic message
                $messageText = match (true) {
                    $type === 'stocksell' || $type === 'stock_created'
                        => "{$chatUser['name']} created an inquiry in Stock Sell {$item['message']}",

                    $type === 'products' || $type === 'product_created' || $type === 'product_approved'
                        => "{$chatUser['name']} showed interest in a product {$item['message']}",

                    $type === 'sale_offer_created' => "{$chatUser['name']} created a new sale offer {$item['message']}",

                    $type === 'buyleads' || $type === 'buy_lead_created'
                        => "{$chatUser['name']} submitted a buy lead inquiry {$item['message']}",

                    $type === 'sellleads' => "{$chatUser['name']} submitted a sell lead inquiry {$item['message']}",

                    $type === 'quotation' => "{$chatUser['name']} submitted a quotation {$item['message']}",
                    // System notifications (underscore or rfq)
                    $isNotification => ucwords(str_replace('_', ' ', $type)) . ' notification',

                    default => "{$chatUser['name']} sent a message {$item['message']}",
                };

                if ($item['category'] === 'chat') {
                    $messageText = "{$chatUser['name']} said: {$item['message']}";
                }

                $hasActionUrl = $isNotification && !empty($item['action_url']);
                $wrapperTag = $hasActionUrl ? 'a' : 'div';
                $backgroundStyle = $isRead
                    ? 'background-color: #d4d4d4; color: #4b5563;'
                    : 'background-color: #ffffff; color: #000; font-weight: 500;';
                $url = match (true) {
                    $isNotification && empty($item['action_url']) => '#',
                    // If action URL is 'inbox', reload the current page
                    $item['action_url'] === 'inbox' => request()->fullUrl(),
                    // If it starts with http(s), leave as is (external or absolute path)
                    str_starts_with($item['action_url'], 'http') => $item['action_url'],
                    // Otherwise, treat it as relative path
                    !empty($item['action_url']) => url($item['action_url']),

                    default => '#',
                };
                $urlmapper = [
                    'products' => '/products/specific_id=',
                    'quotation' => '/buy-leads',
                    'sale-offers' => '/sell-offer/specific_id=',
                    'stocksell' => '/stock-sale/specific_id=',
                    'user_account_created' => '#',
                    'inbox' => '#',
                ];
                $baseUrl = $urlmapper[$item['type']] ?? '#';

                $needsId = str_contains($baseUrl, 'specific_id=');
                $id = $item['ref_id'] ?? ($item['item_id'] ?? null);

                $url = $needsId && $id ? str_replace('specific_id=', $listingId, $baseUrl) : $baseUrl;
            @endphp
            @if ($hasActionUrl)
                <a href="{{ $url }}"
                    onclick="event.preventDefault(); markAsReadAndRedirect({{ $item['id'] }}, '{{ $url }}')"
                    class="flex h-9 px-2 items-center text-sm border-b border-gray-200 hover:shadow-md cursor-pointer
                   {{ $isNotification ? 'border-l-4 border-yellow-400 pl-2' : '' }}
                   {{ $item['category'] === 'chat' ? 'chat-entry' : '' }}"
                    style="{{ $backgroundStyle }}"
                    @unless ($isNotification)
                        data-user-id="{{ $item['receiver_id'] }}"
                        data-user-type="{{ $item['receiver_type'] }}"
                        data-type="{{ $item['type'] }}"
                        data-sendToId="{{ $item['sender_id'] }}"
                        data-sendToType="{{ $item['sender_type'] }}"
                        data-listing-id="{{ $listingId }}"
                    @endunless>
                    <!-- Left: Sender -->
                    <div class="flex items-center w-1/5 text-gray-700 font-semibold truncate">
                        <p class="text-black ml-1">
                            {{ $chatUser['name'] }}
                        </p>
                    </div>

                    <!-- Center: Message -->
                    <div class="flex items-center px-2 w-[70%] justify-between">
                        <div class="w-[98%] overflow-hidden text-ellipsis whitespace-nowrap">
                            <p class="text-black font-semibold">
                                {{ $messageText }}
                            </p>
                        </div>
                        <div class="w-[2%] text-gray-500 font-bold">…</div>
                    </div>

                    <!-- Right: Time -->
                    <div class="flex items-center px-2 h-full font-semibold text-black justify-end w-[15%]">
                        <p class="truncate text-xs text-right">
                            {{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @else
                <div class="flex h-9 px-2 items-center text-sm border-b border-gray-200 hover:shadow-md cursor-pointer
                {{ $isNotification ? 'border-l-4 border-yellow-400 pl-2' : '' }}
                {{ $item['category'] === 'chat' ? 'chat-entry' : '' }}"
                    style="{{ $backgroundStyle }}"
                    @unless ($isNotification)
                    data-user-id="{{ $item['receiver_id'] }}"
                    data-user-type="{{ $item['receiver_type'] }}"
                    data-type="{{ $item['type'] }}"
                    data-sendToId="{{ $item['sender_id'] }}"
                    data-sendToType="{{ $item['sender_type'] }}"
                    data-listing-id="{{ $listingId }}"
                @endunless>
                    <!-- Left: Sender -->
                    <div class="flex items-center w-1/5 text-gray-700 font-semibold truncate">
                        <p class="text-black ml-1">
                            {{ $chatUser['name'] }}
                        </p>
                    </div>

                    <!-- Center: Message -->
                    <div class="flex items-center px-2 w-[70%] justify-between">
                        <div class="w-[98%] overflow-hidden text-ellipsis whitespace-nowrap">
                            <p class="text-black font-semibold">
                                {{ $messageText }}
                            </p>
                        </div>
                        <div class="w-[2%] text-gray-500 font-bold">…</div>
                    </div>

                    <!-- Right: Time -->
                    <div class="flex items-center px-2 h-full font-semibold text-black justify-end w-[15%]">
                        <p class="truncate text-xs text-right">
                            {{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
