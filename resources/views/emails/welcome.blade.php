<x-emails-layout>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		Welcome to Healthy Life, We're thrilled to have you as part of our community.
  	</p> <br>
  
  <p>
    Your presence enriches our space. <br> Feel free to explore available products by clicking the below button. 
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Marketplace
                        </x-button>
                     </td>
                  </tr>
              </table>
  
  	<p><br>

        Regards, <br>
        <strong>Healthy Life Initiative Ltd .</strong>

    </p>

</x-emails-layout>