<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Stripe Payment</title>
    </head>
    <body>

        <div style="text-align:center;">
            <form action="/index.php/stripe-sample-db" method="POST">
                {{ csrf_field() }}
                <script
                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="{{ env('STRIPE_PUB_KEY') }}"
                    data-amount="99"
                    data-name="James Stripe Test Payment"
                    data-description="This is a simple stripe payment."
                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                    data-locale="auto"
                    data-currency="usd">
                </script>
            </form>
        </div>
        
    </body>
</html>