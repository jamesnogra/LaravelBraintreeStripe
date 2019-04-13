<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Test Braintree Payment</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://js.braintreegateway.com/web/dropin/1.8.1/js/dropin.min.js"></script>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div class="container">
     <div class="row">
       <div class="col-md-8 col-md-offset-2">
         <div id="dropin-container"></div>
         <button id="submit-button">Pay with Card</button>
       </div>
     </div>
  </div>

    <div id="loading-screen" style="z-index:100;position:absolute;width:100%;height:100%;background-color:white;opacity:0.75;top:0;left:0;text-align:center;">
        Contacting payment processor, please wait...
    </div>

  <script>
    var button = document.querySelector('#submit-button');
    document.getElementById('loading-screen').style.visibility = 'hidden';

    braintree.dropin.create({
      authorization: "{{ Braintree_ClientToken::generate() }}",
      container: '#dropin-container'
    }, function (createErr, instance) {
      button.addEventListener('click', function () {
        document.getElementById('submit-button').style.visibility = 'hidden';
        document.getElementById('loading-screen').style.visibility = 'visible';
        instance.requestPaymentMethod(function (err, payload) {
          $.get("{{ route('payment.process') }}", {payload}, function (response) {
            if (response.success) {
                console.log(response);
                window.location = "/index.php/braintree-sample-db?currency="+response.transaction.currencyIsoCode+"&amount="+response.transaction.amount;
            } else {
                console.log('FAILED');
                //alert('Payment failed');
            }
          }, 'json');
        });
      });
    });
  </script>
</body>
</html>