document.addEventListener("DOMContentLoaded", function () {
    const openTabNav = document.getElementById("Open-tab");
    const closedTabNav = document.getElementById("Closed-tab");

    const openTabPane = document.getElementById("Open");
    const closedTabPane = document.getElementById("Closed");

    function resetTabs() {
        openTabNav.classList.remove("active");
        closedTabNav.classList.remove("active");

        openTabPane.classList.remove("active", "show");
        closedTabPane.classList.remove("active", "show");
    }

    if (openTabNav && closedTabNav && openTabPane && closedTabPane) {
        openTabNav.addEventListener("click", function (e) {
            e.preventDefault();
            resetTabs();
            openTabNav.classList.add("active");
            openTabPane.classList.add("active", "show");
        });

        closedTabNav.addEventListener("click", function (e) {
            e.preventDefault();
            resetTabs();
            closedTabNav.classList.add("active");
            closedTabPane.classList.add("active", "show");
        });
    } else {
        console.log("Tab elements not found in the DOM.");
    }
});

document
    .getElementById("send-message-btn")
    .addEventListener("click", function (e) {
        e.preventDefault(); // Prevent default form submission

        var loading = document.getElementById('loading');
        loading.classList.remove('d-none');
        loading.classList.add('d-block');
        
        const receiverIdField = document.getElementById("receiver_id").value;
        const receiverTypeField =
            document.getElementById("receiver_type").value;
        const username = document.getElementById("username").innerText;
        const message = document.getElementById("messagesend").value;

        // Collect form data
        const formData = {
            sender_id: document.getElementById("sender_id").value,
            sender_type: document.getElementById("sender_type").value,
            receiver_id: receiverIdField,
            receiver_type: receiverTypeField,
            type: document.getElementById("typereq").value,
            message: message,
            _token: document.querySelector('input[name="_token"]').value,
        };

        const baseUrl = window.location.origin;

        // Send AJAX POST request
        $.ajax({
            url: `${baseUrl}/chat/admin-reply-other`,
            type: "POST",
            data: formData,
            success: function () {
                LoadChats(receiverIdField, username, receiverTypeField);
                loading.classList.add('d-none');
                loading.classList.remove('d-block');
                message.value = "";        
                toastr.success("Message sent successfully!", "Success");
            },
            error: function (xhr) {
                console.error(
                    `Error occurred: ${xhr.statusText} - ${xhr.responseText}`
                );
                toastr.error(
                    "An error occurred while sending the message.",
                    "Error"
                );
            },
        });
    });

function LoadChats(user_id, user_name, user_type,btn_value) {
    console.log(`Chat Loaded: ${user_id}`);

    const baseUrl = window.location.origin;

    var loading = document.getElementById('loading');
    loading.classList.remove('d-none');
    loading.classList.add('d-block');

    var getbuttonvalue = parseInt(btn_value,10);
    var buttonoporcl = document.getElementById('toggle-chat');
    if (getbuttonvalue === 1){
        buttonoporcl.innerText = "Switch";
    } else {
        buttonoporcl.innerText = "Switch";
    }

    // Update username display
    const username = document.getElementById("username");
    if (username) username.innerText = user_name;

    const sender_type = document.getElementById('sender_typemew').value;
    const reciever_type = document.getElementById('reciever_typemew').value;
    const type = document.getElementById('typemew').value;

    // Fetch chat leads via AJAX
    $.ajax({
        url: `${baseUrl}/chatleads/getchat-leads/${user_id}/${user_type}/${type}`,
        type: "POST",
        data: {
            _token: document.querySelector('input[name="_token"]').value,
        },
        success: function (response) {
            console.log("Chats Retrieved Successfully");
            SetIsReadAll(response);
            SendChatData(response,sender_type,reciever_type);
            if (response.length > 0 && response[0]) {
                setSenderData(response[0]);
            }
            loading.classList.add('d-none');
            loading.classList.remove('d-block');        
        },
        error: function (xhr) {
            console.error(
                `Error occurred: ${xhr.statusText} - ${xhr.responseText}`
            );
        },
    });
}

function SetOpenorClose(){
    const baseUrl = window.location.origin;

    $.ajax({
        url: `${baseUrl}/chat/setopenstatus`,
        type: "POST",
        data: {
            _token: document.querySelector('input[name="_token"]').value,
            sender_id : document.querySelector('input[name=receiver_id]').value,
            sender_type : document.querySelector('input[name=receiver_type]').value,
            type : document.querySelector('input[name=typereq]').value
        },
        success: function(response){
            console.log('Chat Status Updated');
            setTimeout(3000);
            window.location.reload();
        },
        error: function(xhr){
            console.error(
                `Error occurred: ${xhr.statusText} - ${xhr.responseText}`
            );
        }
    })
}

function SetIsReadAll(responsedata){
    const baseUrl = window.location.origin;
    $.ajax({
        url: `${baseUrl}/chat/setallread`,
        type: "POST",
        data: {
            _token: document.querySelector('input[name="_token"]').value,
            data: responsedata
        },
        success: function(){
            console.log('Chat Status Updated');
        },
        error: function(xhr){
            console.error(
                `Error occurred: ${xhr.statusText} - ${xhr.responseText}`
            );
        }
    })
}

// Set sender data in hidden fields
function setSenderData(senderData) {
    const receiverIdField = document.getElementById("receiver_id");
    const receiverTypeField = document.getElementById("receiver_type");

    if (receiverIdField && receiverTypeField) {
        if (
            senderData.sender_id !== undefined &&
            senderData.sender_type !== undefined
        ) {
            receiverIdField.value = parseInt(senderData.sender_id, 10); // Set as integer
            receiverTypeField.value = senderData.sender_type; // Set as string
            console.log("Sender Data Set");
        } else {
            console.log("Invalid sender data.");
        }
    } else {
        console.log("Hidden fields not found in the DOM.");
    }
}

// Populate chat messages
function SendChatData(response,sender_type,receiver_type) {
    if (!Array.isArray(response)) {
        console.error("Response is not an array");
        return;
    }

    let chat_code = "";
    let lastDate = null;

    response.forEach((element) => {
        // Parse and validate the `sent_at` field
        const messageDate = new Date(element.sent_at);
        if (isNaN(messageDate)) {
            console.warn("Invalid sent_at date:", element.sent_at);
            return; // Skip this message
        }

        const formattedDate = formatDate(messageDate);

        // Add date divider if the date changes
        if (lastDate !== formattedDate) {
            chat_code += `<li class="divider"><h6>${formattedDate}</h6></li>`;
            lastDate = formattedDate;
        }

        // Safely handle sender types
        if (element.sender_type === sender_type) {
            chat_code += `
            <li class="sender">
                <p>${element.message}</p>
                <span class="time">${formatTime(messageDate)}</span>
            </li>`;
        } else if (element.sender_type === receiver_type) {
            chat_code += `
            <li class="repaly">
                <p>${element.message}</p>
                <span class="time">${formatTime(messageDate)}</span>
            </li>`;
        } else {
            console.warn("Unexpected sender_type:", element.sender_type);
        }
    });

    // Update chat messages in the DOM
    const chatList = document.getElementById("chat-messages");
    if (chatList) {
        chatList.innerHTML = chat_code;
        var body = document.getElementsByClassName('modal-body');
        body[1].scrollTo({
            top: body[1].scrollHeight,
            behavior: 'smooth'
        });    
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

// Check if two dates are on the same day
function isSameDay(date1, date2) {
    return (
        date1.getDate() === date2.getDate() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getFullYear() === date2.getFullYear()
    );
}

// Format time for chat messages
function formatTime(date) {
    return date.toLocaleTimeString("en-US", {
        hour: "2-digit",
        minute: "2-digit",
    });
}

// Function to Filter Chats
function filterChats(){
    console.log("Chats Filtered");
    var query = document.getElementById('inlineFormInputGroup').value.toLowerCase();
    var allchatitems = document.querySelectorAll('.chat-item');
    allchatitems.forEach(element => {
        var chatName = element.getAttribute('data-name').toLowerCase();
        if(chatName.includes(query)){
            element.classList.remove('d-none');
            element.classList.add('d-flex');
        } else {
            element.classList.remove('d-flex');
            element.classList.add('d-none');
        }
    });
}