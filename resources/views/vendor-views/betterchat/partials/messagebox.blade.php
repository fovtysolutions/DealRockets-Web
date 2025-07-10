<div class="bg-white w-full sticky top-0 flex py-2 px-4 text-gray-600 text-[0.7rem] justify-between">
    <div class="flex gap-1">
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3" onclick="location.reload();"><i
                class="fa-solid fa-rotate-right"></i></button>
    </div>
    <div class="flex gap-1">
        <div class="flex items-center h-full rounded-md px-2 cursor-pointer hover:bg-gray-200">
            <p>1-Inf of {{ $count }}</p>
        </div>
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                class="fa-solid fa-chevron-left"></i></button>
        <button class="grid place-content-center rounded-full hover:bg-gray-200 p-3"><i
                class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>
<div class="scrolable-width overflow-y-scroll overflow-x-hidden">
    <div class="hidden md:flex h-12 text-sm font-medium leading-none text-gray-600 border-b border-gray-200"
        style="align-items:center;">
        <h1 style="font-size: 20px; padding-left: 20px;">Messages</h1>
    </div>
    <div class="tab-content-wrapper flex flex-col h-full">
        <div id="tab-all" class="tab-content">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['all'] ?? [],
            ])
        </div>
        <div id="tab-read" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['read'] ?? [],
            ])
        </div>
        <div id="tab-unread" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['unread'] ?? [],
            ])
        </div>
        <div id="tab-rfq" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['buyleads'] ?? [],
            ])
        </div>
        <div id="tab-sell" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['sellleads'] ?? [],
            ])
        </div>
        <div id="tab-stock" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['stocksell'] ?? [],
            ])
        </div>
        <div id="tab-market" class="tab-content hidden">
            @include('vendor-views.betterchat.partials.allentries', [
                'chatdata' => $chatData['products'] ?? [],
            ])
        </div>
        <div id="chatbox" class="hidden ">
            @include('vendor-views.betterchat.partials.messages')
        </div>
    </div>
</div>
<script>
    function markAsReadAndRedirect(id, url) {
        $.ajax({
            method: 'POST',
            url: "{{ route('markAsRead') }}",
            data: {
                id: id,
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log('Message marked as Read');
                // Now redirect
                window.location.href = url;
            },
            error: function(xhr) {
                console.error('Failed to mark as read:', xhr);
                // Optionally still redirect if marking fails
                window.location.href = url;
            }
        });
    }

    $(document).ready(function() {
        let lastActiveTab = 'all'; // default, adjust if needed

        // Hide all tabs helper
        function hideAllTabs() {
            $('.tab-content').addClass('hidden');
        }

        // Show chatbox helper
        function showChatbox() {
            $('#chatbox').removeClass('hidden');
        }

        // Hide chatbox helper
        function hideChatbox() {
            $('#chatbox').addClass('hidden');
        }

        // Show a specific tab
        function showTab(tabId) {
            $('#tab-' + tabId).removeClass('hidden');
            lastActiveTab = tabId;
        }

        function getchatHeaderData(id, firstresponse) {
            $.ajax({
                method: 'POST',
                url: "{{ route('get-chat-header-data') }}",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    let username = document.getElementById('username');
                    let listing_name = document.getElementById('listing_name');
                    let listing_created = document.getElementById('listing_created');

                    let senderType = firstresponse.sender_type.charAt(0).toUpperCase() +
                        firstresponse.sender_type
                        .slice(1);
                    let senderId = firstresponse.sender_id;
                    let type = response.type;
                    let listing = response.listing;

                    username.textContent =
                        `Chat from ${senderType} #${senderId} for ${type} listing`;
                    listing_name.textContent = listing.name;
                    listing_created.textContent = new Date(listing.created_at).toString();
                },
                error: function(xhr) {

                }
            });
        }

        function populateChat(response) {
            let chat_code = "";
            let lastDate = null;

            let firstresponse = response[0];
            getchatHeaderData(firstresponse.id, firstresponse);

            response.forEach((element) => {
                const messageDate = new Date(element.sent_at);
                if (isNaN(messageDate)) {
                    console.warn("Invalid sent_at date:", element.sent_at);
                    return;
                }

                const formattedDate = formatDate(messageDate);

                // Add date divider if the date changes
                if (lastDate !== formattedDate) {
                    chat_code += `<li class="divider"><h6>${formattedDate}</h6></li>`;
                    lastDate = formattedDate;
                }

                // Use the `flag` to determine message alignment
                if (element.flag === "self") {
                    chat_code += `
                <li class="repaly">
                    <p>${element.message}</p>
                    <span class="time">${formatTime(messageDate)}</span>
                </li>`;
                } else if (element.flag === "other") {
                    chat_code += `
                <li class="sender">
                    <p>${element.message}</p>
                    <span class="time">${formatTime(messageDate)}</span>
                </li>`;
                } else {
                    console.warn("Unexpected flag value:", element.flag);
                }
            });

            // Update chat DOM
            const chatList = document.getElementById("chat-messages");
            if (chatList) {
                chatList.innerHTML = chat_code;
                const body = document.getElementsByClassName('modal-body');
                if (body[1]) {
                    body[1].scrollTo({
                        top: body[1].scrollHeight,
                        behavior: 'smooth'
                    });
                }
            } else {
                console.error("Chat messages container not found");
            }
        }

        // Format date for chat messages
        function formatDate(date) {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            if (isSameDay(date, today)) {
                return "Today";
            } else if (isSameDay(date, yesterday)) {
                return "Yesterday";
            } else {
                return date.toLocaleDateString("en-US", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric",
                });
            }
        }

        // Format time for chat messages
        function formatTime(date) {
            return date.toLocaleTimeString("en-US", {
                hour: "2-digit",
                minute: "2-digit",
            });
        }

        // Check if two dates are on the same day
        function isSameDay(date1, date2) {
            return (
                date1.getDate() === date2.getDate() &&
                date1.getMonth() === date2.getMonth() &&
                date1.getFullYear() === date2.getFullYear()
            );
        }

        function loadChat(userId, userType, type, listingId) {
            let url = `/chat-by-listing/${userId}/${userType}/${type}/${listingId}`;

            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    // Populate Chat
                    populateChat(response);
                },
                error: function(xhr) {
                    console.error(`Error occurred: ${xhr.statusText} - ${xhr.responseText}`);
                },
            });
        }

        // When a tab button is clicked (your existing code)
        $('.custom-tab-button').on('click', function() {
            const tabId = $(this).data('tab');

            // Hide all tabs and chatbox
            hideAllTabs();
            hideChatbox();

            // Show the clicked tab content
            showTab(tabId);
        });

        // When a tab button is clicked (your existing code)
        $('.tab-button').on('click', function() {
            const tabId = $(this).data('tab');

            // Remove active styles from all buttons
            $('.tab-button').removeClass('active-tab text-blue-600 border-blue-600 border-b-[3px]');

            // Add active styles to clicked button
            $(this).addClass('active-tab text-blue-600 border-blue-600 border-b-[3px]');

            // Hide all tabs and chatbox
            hideAllTabs();
            hideChatbox();

            // Show the clicked tab content
            showTab(tabId);
        });

        // When any chat entry is clicked
        $('.chat-entry').on('click', function() {
            // Save last active tab container ID (for closing chatbox later)
            lastActiveTab = $(this).closest('.tab-content').attr('id').replace('tab-', '');

            // Hide all tab contents
            hideAllTabs();

            // Show chatbox
            showChatbox();

            // Render Chat
            let userId = this.dataset.userId;
            let userType = this.dataset.userType;
            let type = this.dataset.type;
            let listingId = this.dataset.listingId;
            let sendtoId = this.dataset.sendtoid;
            let sendtoType = this.dataset.sendtotype;

            // Setup Reply Function 
            document.getElementById('typeuniq').value = type;
            document.getElementById('receiver_iduniq').value = sendtoId;
            document.getElementById('receiver_typeuniq').value = sendtoType;
            document.getElementById('listing_id').value = listingId;

            loadChat(userId, userType, type, listingId);
        });

        // Close chat button click
        $('#closeChat').on('click', function() {
            hideChatbox();
            showTab(lastActiveTab);

            // Disable input again (no chat)
            $('#chatInput, #chatForm button').prop('disabled', true);

            // Clear chat messages
            $('#chatMessages').html(
                '<p class="text-gray-500">Select a conversation to start chatting.</p>');
        });

        $('#chatForm').on('submit', function(e) {
            e.preventDefault();

            const message = $('#chatinput').val().trim();
            if (!message) return;

            const formData = {
                sender_id: $('#sender_id').val(), // assuming hidden input with auth user ID
                sender_type: $('#sender_type').val(), // assuming hidden input with auth user type
                receiver_id: $('#receiver_iduniq').val(),
                receiver_type: $('#receiver_typeuniq').val(),
                listing_id: $('#listing_id').val(),
                message: message,
                type: $('#typeuniq').val(),
                _token: "{{ csrf_token() }}", // or pass it explicitly
            };

            $.ajax({
                type: 'POST',
                url: '{{ route('send-reply-message') }}',
                data: formData,
                success: function(response) {
                    $('#chatInput').val(''); // clear input
                    toastr.success('Replied Successfully');
                    loadChat(formData.sender_id, formData.sender_type, formData.type, $(
                        '#listing_id').val());
                },
                error: function(xhr) {
                    alert('Failed to send message: ' + xhr.responseText);
                },
            });
        });
    });
</script>
