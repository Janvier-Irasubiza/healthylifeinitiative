<x-emails-layout>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0"><br>
          {!! $replied == false ? 'You have received a new message from <strong>' . $senderNames . '</strong>' : 'You have received a reply to your message.' !!}
    </p>
    <br>
  
  {{ $replied == false ? 'Message:' : 'Reply:' }}
  <div style="border: 1px solid #e6e6e6; padding: 6px 10px; border-radius: 4px">
    <p>
      {{ $message }}
    </p>
    </div>
  
  <br>
  
  <p>
    You can reply to this message by clicking below button.
    </p> <br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Reply
                        </x-button>
                     </td>
                  </tr>
              </table>

</x-emails-layout>