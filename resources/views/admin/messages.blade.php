@section('title', 'Messages')

<x-ht-admin-layout>

<div class="body-content d-flex justify-content-center">

<div class="chts col-lg-9 py-3 px-2 rounded">
<h1 class="msgs-title">Messages</h1>

<div class="flex-section gap-1">
    
<div class="chts-p col-lg-4 mt-3 border border-transparent rounded" id="messagesContainer">
@foreach($messages as $chat)
        @if($chat->is_read == 'no')
            @if(!is_null($chat->reply))
                @php
                    $msgs = explode('::;;', $chat->reply);
                    $lastMessage = strlen(end($msgs)) > 40 ? substr(end($msgs), 0, 40) . '...' : end($msgs);
                @endphp
            @else
                @php
                    $lastMessage = strlen($chat->message) > 40 ? substr($chat->message, 0, 40) . '...' : $chat->message;
                @endphp
            @endif
            <button class="cht-tbn w-full text-left px-3 pt-2 pb-1" style="border-bottom: 1px solid #ddd" data-user-id="{{ $chat->sender }}" data-message-id="{{ $chat->id }}" onclick="fetchUserMessages(this)">
                <div>
                    <label class="fw-500 w-full" style="font-size: 16px">{{ $chat->name }}</label>
                </div>
                <div style="position: relative; top: -5px">
                    <label class="w-full lastMessage"><small class="lastMessage" data-message-id="{{ $chat->id }}" style="font-weight: 600; color: #595959">{{ $lastMessage }}</small></label>
                </div>
            </button>
        @else 
            <button class="cht-tbn w-full text-left px-3 pt-2 pb-1" style="border-bottom: 1px solid #ddd" data-user-id="{{ $chat->sender }}" data-message-id="{{ $chat->id }}" onclick="fetchUserMessages(this)">
                <div>
                    <label class="fw-500 w-full" style="font-size: 16px">{{ $chat->name }}</label>
                </div>
                <div style="position: relative; top: -5px">
                    <label class="w-full lastMessage"><small class="lastMessage" data-message-id="{{ $chat->id }}" style="font-weight: 600; color: #595959">{{ $chat->message }}</small></label>
                </div>
            </button>
        @endif
@endforeach

</div>

<div class="msg-cont w-full">
<div class="chts-msgs mt-3 border border-transparent rounded">

    <div id="userMessagesContainer" style="display: none;">
        
        @include('partials.messages')

    </div>

</div>
</div>

</div>

<script>

    $(document).ready(function() {
        autoLoadMessages();
    });

    function fetchNewMessages() {
        $.ajax({
            url: '/messages/latest',
            type: 'GET',
            success: function (response) {
                
                response.forEach(function (msg) {

                    var messageId = msg.id;
                    var lastMessageElement = $('[data-message-id="' + messageId + '"] .lastMessage');

                    var lastMessage;

                    if (msg.reply !== null && msg.reply !== '') {
                        lastMessage = msg.reply.split('::;;').pop();
                    } else {
                        lastMessage = msg.message;
                    }
                    lastMessageElement.text(lastMessage);
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function fetchUserMessages(button) {
        var userId = $(button).data('user-id');

        $.ajax({
            url: '/messages/' + userId + '/all',
            type: 'GET',
            success: function(response) {
                $('#userMessagesContainer').html(response).show();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function autoLoadMessages() {
        setInterval(function() {
            fetchNewMessages();
        }, 5000); 
    }
    
</script>

</x-ht-admin-layout>
