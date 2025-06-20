<div class="chatbox ">
    <div class="modal-dialog ">
        <div class="modal-content " style="display: flex;">
            <div class="msg-head">
                <div class="row">
                    <div class="col-10">
                        <div class="d-flex align-items-center">
                            <span class="chat-icon"><img class="img-fluid"
                                    src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg"
                                    alt="image title"></span>
                            <div class="flex-shrink-0">
                                <img style="max-width:50px;" class="img-fluid" src="/images/missing_image.jpg"
                                    alt="user img">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h3 id="username">Select a Chat from left sidebar</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="flex-grow-1 ms-3">
                            <button type="button" id="closeChat" class="btn btn--primary m-2" style="background-color: #E72528;color: white;padding: 10px;">
                                Close Chat
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;margin-left: 20px;flex-direction: column;">
                    <h5 id="listing_name"></h5><br>
                    <span id="listing_created"> </span>
                </div>
            </div>
            <div class="modal-body">
                <div class="msg-body">
                    <ul id="chat-messages">
                        <h5>Select a Chat</h5>
                    </ul>
                </div>
            </div>
            <div class="send-box">
                <?php
                $userdata = \App\Utils\ChatManager::getRoleDetail();
                $user_id = $userdata['user_id'];
                $role = $userdata['role'];
                ?>
                <form id="chatForm">
                    @csrf
                    <input type="hidden" name="type" id="typeuniq" value="">
                    <input type="hidden" name="sender_id" id="sender_id" value="{{ $user_id }}">
                    <input type="hidden" name="sender_type" id="sender_type" value="{{ $role }}">
                    <input type="hidden" name="receiver_id" id="receiver_iduniq" value="">
                    <input type="hidden" name="receiver_type" id="receiver_typeuniq" value="">
                    <input type="hidden" name="listing_id" id="listing_id" value=""> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="text" id="chatinput" class="form-control" aria-label="message…"
                        placeholder="Write message…">
                    <button id="send-message-btn" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
