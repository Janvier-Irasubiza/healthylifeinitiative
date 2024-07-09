<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Health Target - @yield('title')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
  
    <style>
.pyt-lyt {
    width: 100%;
    padding: 5px;
}

      .inv-holder {
        display: flex;
      }

      .content-center {
        justify-content: center
      }
      
.inv-from {
    text-align: right;
}

.date {
    margin-bottom: 30px;
}

.sm-pyt-wrapper {
    display: none;
}

.muted-text {
    color: #b3b3b3;
}

.cap {
    text-transform: uppercase;
}

.f-12 {
    font-size: 12px;
}

.f-13 {
    font-size: 13px;
}

.f-14 {
    font-size: 14px;
}

.f-15 {
    font-size: 15px;
}

.f-16 {
    font-size: 16;
}

.f17 {
    font-size: 17px;
}

.f-18 {
    font-size: 18px;
}
      
      .in-holder {
        border: 1px solid #ccc;
        border-radius: 8px
      }
      
      
.mt-4 {
    margin-top: 1.5rem !important;
}

.p-3 {
    padding: 1rem !important;
}

.alert {
    position: relative;
    padding: 0.15rem 1.25rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: 0.25rem;
}

.alert-warning {
    color: #856404;
    background-color: #fff3cd;
    border-color: #ffeeba;
}

.mb-4 {
    margin-bottom: 1.5rem !important;
}

.d-flex {
    display: flex !important;
}

.justify-content-start {
  justify-content: flex-start !important;
}

.justify-content-end {
  justify-content: flex-end !important;
}

.justify-content-center {
  justify-content: center !important;
}

.justify-content-between {
  justify-content: space-between !important;
}
      
.align-items-center {
    align-items: center !important;
}

.border {
    border: 1px solid #ddd;
}

.rounded {
    border-radius: 0.25rem;
}

.px-4 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
}

.text-right {
    text-align: right !important;
}

.mt-5 {
    margin-top: 2.5rem !important;
}

.py-3 {
    padding-top: 1.5rem !important;
    padding-bottom: 1.5rem !important;
}

.cap {
    text-transform: capitalize;
}

.muted-text {
    color: #6c757d !important;
}

.f-13 {
    font-size: 13px !important;
}

.f-14 {
    font-size: 14px !important;
}

.f-15 {
    font-size: 15px !important;
}

.f-16 {
    font-size: 16px !important;
}

.fw-500 {
    font-weight: 500 !important;
}
      
      footer {
    background-color: #ECECEC;
    padding: 30px 30px 10px 30px;
}
      
      .pyt-footer {
    padding: 10px;
}

      .flex-section {
    display: flex;
}

      .f-footer {
    display: flex;
    justify-content: space-between;
    padding: 5px;
}
      
      
.a-footer {
    display: flex;
    justify-content: space-between;
    padding: 5px;
}
      
      
.rsp-f-footer {
    display: none;
}
      
      
.p-0 {
  padding: 0 !important;
}

.p-1 {
  padding: 0.25rem !important;
}

.p-2 {
  padding: 0.5rem !important;
}

.p-3 {
  padding: 1rem !important;
}

.p-4 {
  padding: 1.5rem !important;
}

.p-5 {
  padding: 3rem !important;
}

.px-0 {
  padding-right: 0 !important;
  padding-left: 0 !important;
}

.px-1 {
  padding-right: 0.25rem !important;
  padding-left: 0.25rem !important;
}

.px-2 {
  padding-right: 0.5rem !important;
  padding-left: 0.5rem !important;
}

.px-3 {
  padding-right: 1rem !important;
  padding-left: 1rem !important;
}

.px-4 {
  padding-right: 1.5rem !important;
  padding-left: 1.5rem !important;
}

.px-5 {
  padding-right: 3rem !important;
  padding-left: 3rem !important;
}

.py-0 {
  padding-top: 0 !important;
  padding-bottom: 0 !important;
}

.py-1 {
  padding-top: 0.25rem !important;
  padding-bottom: 0.25rem !important;
}

.py-2 {
  padding-top: 0.5rem !important;
  padding-bottom: 0.5rem !important;
}

.py-3 {
  padding-top: 1rem !important;
  padding-bottom: 1rem !important;
}

.py-4 {
  padding-top: 1.5rem !important;
  padding-bottom: 1.5rem !important;
}

.py-5 {
  padding-top: 3rem !important;
  padding-bottom: 3rem !important;
}
      
      .form-title-sub {
    font-size: 20px;
    font-weight: 500;
}
.table {
  --bs-table-color: var(--bs-body-color);
  --bs-table-bg: transparent;
  --bs-table-border-color: var(--bs-border-color);
  --bs-table-accent-bg: transparent;
  --bs-table-striped-color: var(--bs-body-color);
  --bs-table-striped-bg: rgba(0, 0, 0, 0.05);
  --bs-table-active-color: var(--bs-body-color);
  --bs-table-active-bg: rgba(0, 0, 0, 0.1);
  --bs-table-hover-color: var(--bs-body-color);
  --bs-table-hover-bg: rgba(0, 0, 0, 0.075);
  width: 100%;
  margin-bottom: 1rem;
  color: var(--bs-table-color);
  vertical-align: top;
  border-color: var(--bs-table-border-color);
}
.table > :not(caption) > * > * {
  padding: 0.5rem 0.5rem;
  background-color: var(--bs-table-bg);
  border-bottom-width: 1px;
  box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
}
.table > tbody {
  vertical-align: inherit;
}
.table > thead {
  vertical-align: bottom;
}

.table-group-divider {
  border-top: 2px solid currentcolor;
}

.caption-top {
  caption-side: top;
}

.table-sm > :not(caption) > * > * {
  padding: 0.25rem 0.25rem;
}

.table-bordered > :not(caption) > * {
  border-width: 1px 0;
}
.table-bordered > :not(caption) > * > * {
  border-width: 0 1px;
}

.table-borderless > :not(caption) > * > * {
  border-bottom-width: 0;
}
.table-borderless > :not(:first-child) {
  border-top-width: 0;
}

.table-striped > tbody > tr:nth-of-type(odd) > * {
  --bs-table-accent-bg: var(--bs-table-striped-bg);
  color: var(--bs-table-striped-color);
}

.table-striped-columns > :not(caption) > tr > :nth-child(even) {
  --bs-table-accent-bg: var(--bs-table-striped-bg);
  color: var(--bs-table-striped-color);
}

.table-active {
  --bs-table-accent-bg: var(--bs-table-active-bg);
  color: var(--bs-table-active-color);
}

.table-hover > tbody > tr:hover > * {
  --bs-table-accent-bg: var(--bs-table-hover-bg);
  color: var(--bs-table-hover-color);
}

.table-primary {
  --bs-table-color: #000;
  --bs-table-bg: #cfe2ff;
  --bs-table-border-color: #bacbe6;
  --bs-table-striped-bg: #c5d7f2;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #bacbe6;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #bfd1ec;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-secondary {
  --bs-table-color: #000;
  --bs-table-bg: #e2e3e5;
  --bs-table-border-color: #cbccce;
  --bs-table-striped-bg: #d7d8da;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #cbccce;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #d1d2d4;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-success {
  --bs-table-color: #000;
  --bs-table-bg: #d1e7dd;
  --bs-table-border-color: #bcd0c7;
  --bs-table-striped-bg: #c7dbd2;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #bcd0c7;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #c1d6cc;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-info {
  --bs-table-color: #000;
  --bs-table-bg: #cff4fc;
  --bs-table-border-color: #badce3;
  --bs-table-striped-bg: #c5e8ef;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #badce3;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #bfe2e9;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-warning {
  --bs-table-color: #000;
  --bs-table-bg: #fff3cd;
  --bs-table-border-color: #e6dbb9;
  --bs-table-striped-bg: #f2e7c3;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #e6dbb9;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #ece1be;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-danger {
  --bs-table-color: #000;
  --bs-table-bg: #f8d7da;
  --bs-table-border-color: #dfc2c4;
  --bs-table-striped-bg: #eccccf;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #dfc2c4;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #e5c7ca;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-light {
  --bs-table-color: #000;
  --bs-table-bg: #f8f9fa;
  --bs-table-border-color: #dfe0e1;
  --bs-table-striped-bg: #ecedee;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #dfe0e1;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #e5e6e7;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-dark {
  --bs-table-color: #fff;
  --bs-table-bg: #212529;
  --bs-table-border-color: #373b3e;
  --bs-table-striped-bg: #2c3034;
  --bs-table-striped-color: #fff;
  --bs-table-active-bg: #373b3e;
  --bs-table-active-color: #fff;
  --bs-table-hover-bg: #323539;
  --bs-table-hover-color: #fff;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color);
}

.table-responsive {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

@media (max-width: 575.98px) {
  .table-responsive-sm {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}
@media (max-width: 767.98px) {
  .table-responsive-md {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}
@media (max-width: 991.98px) {
  .table-responsive-lg {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}
@media (max-width: 1199.98px) {
  .table-responsive-xl {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}
@media (max-width: 1399.98px) {
  .table-responsive-xxl {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
}
      
      .p-btns {
    background-color: #0C8845 !important;
    border-radius: 4px;
    text-align: center;
    color: ghostwhite;
    padding: 8px 20px;
    transition: background-color 0.3s ease-in-out;
    font-size: 13px;
    text-transform: uppercase;
        font-weight: 500
}
      
      .p-btns:hover {
    color: ghostwhite;
    background-color: #0a5c30 !important;
}
 
      @media (max-width: 300px), (max-width: 380px), (max-width: 500px), (max-width: 425px), (max-width: 600px), (max-width: 750px) {
      
      
         footer {
        padding: 30px 10px 10px 10px;
    }
          .f-footer {
        display: none;
    }

    .rsp-f-footer {
        display: flex;
        font-size: 12px;
        align-items: center;
        justify-content: space-between;
    }

    .rsp-f-footer .dev {
        font-size: 11px;
    }
    
        .flex-section {
    display: block;
}
        
   .pyt-lyt {
        width: calc( 100% - 1.5em);
        padding: 5px;
    }

    .inv-from {
        text-align: left;
        margin-top: 30px;
    }

    .date {
        margin-bottom: 20px;
    }
  
  
    .sm-pyt-wrapper {
        display: block;
    }

  
  .product-name {
      font-size: 20px;
      font-weight: 500;
  }

      
      }
    </style>
    </head>
<body>

<main class="d-flex justify-content-center">

    <div class="pyt-lyt" style="width: 100%; padding: 5px;">

        <br>
        <p class="mb-0">
            You have successfully placed an order in <strong>Healthy Life Initiative Ltd.</strong>
        </p>
        <br>

        <p>
            Our team will get back to you soon. <br> Thank you for trusting us.
        </p>
        <br>

        <p> This is an invoice for your order. Check it out! </p>
        <br>

        <div class="border rounded p-3" style="margin-top: 20px;">

            <div class="mt-2 alert alert-warning" role="alert">
                <p class="m-0 f-14" style="justify-content: center !important; vertical-align: middle;"></p>
                    <p class="m-0 f-14 fw-500">Please be informed that Your order due in 30 days. expires on {{ $client->due_date }}</p>
            </div>

            <div class="date">
                <p class="m-0">
                    <strong class="f-13">
                        Issue Date: {{ $client->requested_on }}
                    </strong>
                </p>
            </div>

            <div>
                <div>
                    <h4 class="mb-3 form-title-sub f-16">Invoice to</h4>
                    <div>
                        <p class="form-title-sub m-0 f-15"> {{ $client->client_names }}</p>
                        <p class="m-0 f-14">{{ $client->client_email }}</p>
                        <p class="m-0 f-14">{{ $client->client_phone }}</p>
                    </div>
                </div>
                <div class="" style="margin-top: 20px;">
                    <h5 class="mb-3 form-title-sub">Invoice from</h5>
                    <div>
                        <p class="m-0 form-title-sub f-15">Healthy Life initiative</p>
                        <p class="m-0 f-14">healthylifeinitiative2024@gmail.com</p>
                        <p class="m-0 f-14">+250 793 083 966</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 border rounded p-2">
                <p class="m-0 f-14 fw-500">
                    <span class="cap"> Order number: </span>
                    <strong class="">
                        {{ $client->order_number }}
                    </strong>
                </p>
            </div>

            <div class="mt-4 wrapper">
                <table class="w-full table">
                    <thead>
                        <tr>
                            <th style="text-align: left" class="cap text-left muted-text f-12">QUANTITY</th>
                            <th style="text-align: left" class="cap text-left muted-text f-12">PRODUCT</th>
                            <th style="text-align: right" class="text-right cap muted-text f-12">PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                        <tr style="border-bottom: 1px solid #ddd">
                            <td class="px-4 f-13">
                                {{ $orderInfo[$key]->quantity }}
                            </td>
                            <td class="f-13">
                                {{ $product->name }}
                            </td>
                            <td class="text-right f-13">
                                <strong>
                                    @if(!is_null($product->promo_price))
                                    {{ number_format($product->promo_price * $orderInfo[$key]->quantity) }}
                                    @else 
                                    {{ number_format($product->price * $orderInfo[$key]->quantity) }}
                                    @endif
                                    RWF
                                </strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <table class="w-full table">
                    <thead>
                        <tr>
                            <th style="text-align: left" class="cap text-left muted-text f-12">PAYMENT INFO</th>
                            <th style="text-align: left" class="muted-text text-left cap f-12">DUE BY</th>
                            <th style="text-align: right" class="muted-text text-right cap f-12 text-right">TOTAL DUE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-3">
                                <p class="f-13">MoMo Pay: <strong>05452</strong></p>
                                <p class="f-13">Phone number: <strong>+250 785 543 234</strong></p>
                            </td>
                            <td class="py-3">
                                <p class="f-13">
                                    <strong>{{ $client->due_date }}</strong>
                                </p>
                            </td>
                            <td class="py-3 text-right f-13">
                                <strong>
                                    {{ number_format($totalDue) }} RWF
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
          
          <div class="mt-2 alert alert-warning" role="alert">
                <p class="m-0 f-14" style="justify-content: center !important; vertical-align: middle;"></p>
                    <p class="m-0 f-14 fw-500">Please share us a screenshot of your paymeny to this Whatsapp number: +250 793 083 966</p>
            </div>

        </div>

        <div style="padding: 20px">
            Continue ordering with Healthy Life Initiative Ltd by clicking the below button.

            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
                <tr>
                    <td align="center">
                        <a style="border: none; text-decoration: none;" class="p-btns" href="{{ $url }}">
                            Explore more
                        </a>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</main>

<script>
    $('.drower').on('click', function () {
        $('.rsp-nav').toggleClass('show');
    });
</script>

</body>
</html>
