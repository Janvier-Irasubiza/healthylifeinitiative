
@if(!empty($userMessages))

<div class="w-full">
<div class="msg-div w-full text-left d-flex gap-4 px-3 pt-2 pb-1" style="border-bottom: 1px solid #ddd">
        <button class="back-btn">
            <i style="font-size: 20px" class="fa-solid fa-angle-left"></i>
        </button>

        <a href="" class="cht-tbn-a w-full">
            <div>
                <label class="fw-500 w-full" style="font-size: 16px">{{ $user->name }}</label>
            </div>
            <div style="position: relative; top: -5px">
                <label class="w-full"><small style="font-weight: 500; color: #595959">Phone: {{ $user->phone }} </small></label>
            </div>
        </a>
    </div>

    <div id="userMessagesContainer" class="w-full px-3 cont" style="max-height: calc(100vh - 350px)">

        @foreach($userMessages as $msg)
            <div class="py-2">
                <div class="d-flex justify-content-start mb-1">
                    <div  style="max-width: 80%">
                        <p class="rounded msg-bg">
                            <span class="" style="font-size: 14px">
                                {{$msg->message}}
                            </span>
                        </p>
                    </div>
                </div>

                @php
                    $msgs = explode('::;;', $msg->reply)
                @endphp

                @foreach($msgs as $section)
                <div class="mt-1 d-flex justify-content-end mb-1">
                    <div style="max-width: 80%">
                        <p class="msg-bg rounded" style="">
                            <span class="" style="font-size: 14px">
                                {{$section}}
                            </span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach

        <div class="mb-1" id="msgContainer"></div>

    </div>
    <form id="sendMessageForm"> @csrf
        <div class="mt-2 d-flex justify-content-between gap-2 pr-3 rounded border border-transparent">
            <input type="hidden" name="sender" value="{{ $user->id }}">
            <input autofocus id="messageInput" type="text" name="message" placeholder="Type here..." class="w-full" style="border-right: 1px solid #ddd; border-left: none; border-top: none; border-bottom: none; border-radius: 6px 0px 0px 6px">
            <button id="sendMessageButton" type="button" style="font-size: 20px; top: 5px; float: right">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>
    </form>
    </div>   
    </div>   

    @endif

    <script>

    var scrollableDiv = $(".cont");

    function scrollToBottom() {
        scrollableDiv.scrollTop(scrollableDiv.prop("scrollHeight"));
    }

    function loadNewMessages() {
        $.ajax({
            url: '/admin/load-new-messages',
            type: 'GET',
            success: function(response) {
                // Update UI with new messages
                response.forEach(function(message) {
                    const content = '<div class="d-flex justify-content-start">'+
                                    '<div style="max-width: 80%">'+
                                        '<p class="msg-bg rounded" style="">'+
                                            '<span class="" style="font-size: 14px">'+ message.message +
                                            '</span>'+
                                        '</p>'+
                                    '</div>'+
                                '</div>';
                    $('#msgContainer').append(content);
                });
                
                // Scroll to the bottom
                scrollToBottom();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).ready(function() {
        setInterval(loadNewMessages, 3000);

        $('#messageInput').keypress(function(event) {
            if (event.keyCode === 13) { 
                event.preventDefault(); 
                $('#sendMessageButton').click(); 
            }
        });
      
        scrollToBottom();

        $('#sendMessageButton').click(function(e) {
            e.preventDefault();
            var message = $('#messageInput').val();
            const container = $('#msgContainer');

            if(message.length !== 0) {
                $.ajax({
                    url: '/admin/send-msg',
                    type: 'POST',
                    data: $('#sendMessageForm').serialize(),
                    success: function(response) {
                        const content = '<div class="d-flex justify-content-end">'+
                                        '<div style="max-width: 80%">'+
                                            '<p class="msg-bg rounded" style="">'+
                                                '<span class="" style="font-size: 14px">'+ message +
                                                '</span>'+
                                            '</p>'+
                                        '</div>'+
                                    '</div>';
                        container.append(content);
                        $('#messageInput').val('');
                        scrollToBottom();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
      
      $('.back-btn').on('click', function () {
          $('.msg-cont').toggleClass('show');
          $('.chts-p').toggleClass('hide');
      });
      
    });
     
      
    </script>