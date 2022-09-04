<div id="paypal-button-container" data-url="{{ $attributes->get('url') }}" data-price="{{ $attributes->get('price') }}" wire:ignore></div>

@section('scripts')

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo env('PAYPAL_ID_COMPANY');?>&currency=USD"></script>
    <script>


        // const pathname = window.location.pathname.split('/')
        // const premiumShoppingId = pathname.slice(-1)[0]

        paypal.Buttons({
            style: {
                layout: 'horizontal',
            },
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    intent: 'capture',
                    purchase_units: [{
                        amount: {
                            //value: document.querySelector('#paypal-button-container').getAttribute('data-price') // Can also reference a variable or function
                            value: $('#amoutPaypal').val()
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval
            onApprove: (data, actions) => {

                return actions.order.capture().then(function(orderData) {
                    // Successful capture! For dev/demo purposes:
            // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            // const transaction = orderData.purchase_units[0].payments.captures[0];
            // console.log('Order ID', data.orderID);

                     // Successful capture! For dev/demo purposes:
                    //console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    //alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                    // When ready to go live, remove the alert and show a success message within this page. For example:
                    // var element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    //alert(`?transaction=${transaction.id}`);
                    //{data.orderID}
                    window.location.href = document.querySelector('#paypal-button-container').getAttribute('data-url') +`?transaction=${data.orderID}`;
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection

