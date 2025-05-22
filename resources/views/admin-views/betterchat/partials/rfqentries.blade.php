@foreach ($chatdata as $item)
    <div class="flex h-9 px-2 items-center text-sm border-b border-gray-200 hover:shadow-md cursor-pointer md:py-0 py-6">
        <!-- mail right section  -->
        <div class="flex text-gray-600 h-full leading-none items-center font-semibold w-1/5 py-1">
            <div class="md:grid place-content-center h-full w-8 rounded-full hover:bg-gray-200 hidden">
                <input type="checkbox" name="" id="">
            </div>
            <button class="md:grid hidden place-content-center rounded-full hover:bg-gray-200 p-2"><i
                    class="fa-regular fa-star"></i></button>
            <p class="text-black ml-1">{{ \App\Utils\ChatManager::getUserDataChat($item['sender_id'],$item['sender_type'])['name'] }}</p>

        </div>
        <!-- mail middle sections  -->
        <div class="flex leading-none items-center py-1 px-2 w-[70%] h-full justify-between">
            <div class="flex w-[98%] overflow-hidden text-ellipsis whitespace-nowrap">
                <p class="text-black font-semibold">{{ \App\Utils\ChatManager::getUserDataChat($item['receiver_id'],$item['receiver_type'])['name'] }} got a Inquiry from RFQ: {{ $item['message'] }}</p>
            </div>
            <p class="w-[2%]">...</p>
        </div>
        <!-- mail right section  -->
        <div style="text-wrap-mode: nowrap;"
            class="flex leading-none items-center py-1 px-2 h-full font-semibold text-black justify-end ml-[10px]">
            <p>{{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}</p>
        </div>
    </div>
@endforeach
