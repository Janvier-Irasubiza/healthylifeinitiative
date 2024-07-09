<x-emails-layout>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $clientName }}, <br>
  		Your order for {{ $url }} from Healthy Life Initiative Ltd is now {{ $status }}.
  	</p> <br>
  
	{!! isset($note) ? '<p>' . $note . '</p><br>' : '' !!}
  
  <p>
    Anticipate a feedack from us soon. <br> Feel free to track your order's progress and make more orders by clicking the below button. 
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$prodName">
                           My Dashboard
                        </x-button>
                     </td>
                  </tr>
              </table>
  
  	<p><br>

        Regards, <br>
        <strong>Healthy Life Initiative Ltd .</strong>

    </p>

</x-emails-layout>