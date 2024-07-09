@section('title', 'Messages')

<x-ht-clt-layout>

<div class="body d-flex justify-content-center">

<div class="chts col-lg-7 px-3" style="border: none">
<div class="flex-section gap-1">

<div class="w-full">
<div class="chts-msgs mt-3 rounded border border-transparent">
<div class="msg-div d-flex justify-content-between w-full text-left px-3 pt-2 pb-1" style="border-bottom: 1px solid #ddd">
<button class="cht-tbn-a text-left">
    <div>
        <label class="fw-500 w-full" style="font-size: 16px">Health Target</label>
    </div>
    <div style="position: relative; top: -5px">
        <label class="w-full"><small style="font-weight: 500; color: #595959">Phone: +250 780 478 405 </small></label>
    </div>
</button>
  
  <a href="" class="font-weight: 700" style="font-size: 25px; color: green;">
    <i class="fab fa-whatsapp"></i>
</a>
</div>

<div class="w-full px-3 cont">

@if(!$messages->isEmpty())
@foreach($messages as $msg)
            <div class="py-2">
                <div class="d-flex justify-content-end mb-1">
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
                <div class="mt-1 d-flex justify-content-start mb-1">
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
</div>
@else
<div class="px-3">
<div class="py-2">
    <div class="d-flex justify-content-center">
        <div style="max-width: 80%">
        <p class="text-center py-2 m-0" style="color: gray">
            <span class="f-12">You seem not to have any message with us yet! <br> Mind starting one? </span>
        </p>
        </div>
    </div>

</div>
</div>
@endif

</div>

<form action="{{ route('client.message') }}" method="post">
@csrf
<div class="mt-2 d-flex justify-content-between gap-2 pr-3 rounded border border-transparent">
    <input name="message" type="text" placeholder="Type here..." class="w-full " style="border-right: 1px solid #ddd; border-left: none; border-top: none; border-bottom: none; border-radius:  4px 0px 0px 4px">
        <button type="submit" style="font-size: 20px; top: 5px; float: right">
            <i class="fa-solid fa-paper-plane"></i>    
        </button>
</div>
</form>

</div>
</div>

</div>

<script>
    var scrollableDiv = $(".cont");
    
    function scrollToBottom() {
        scrollableDiv.scrollTop(scrollableDiv.prop("scrollHeight"));
    }

    $(document).ready(function() {
        scrollToBottom();
    });

</script>

</x-ht-clt-layout>