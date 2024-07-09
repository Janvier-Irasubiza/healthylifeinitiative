<x-emails-layout>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $clientName }}, <br>
  		Your order for {{ $url }} from Healthy Life Initiative Ltd is now {{ $status }}.
  	</p> <br>
  
  <p>
    Thank you for working with us! <br> Feel free to make more orders by clicking the below button. 
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