<div id="paypal-button-container" style="height: 48px;" data-url="{{ $attributes->get('url') }}" data-amount-to-pay="{{ $attributes->get('amountToPay') }}" wire:ignore></div>
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_ID_COMPANY') }}&currency=USD&intent=capture"></script>

@push('bottom-scripts')
<script>
    const fundingSources = [
        paypal.FUNDING.PAYPAL
    ]

    for (const fundingSource of fundingSources) {
        const paypalButtonsComponent = paypal.Buttons({
            fundingSource: fundingSource,

            // optional styling for buttons
            // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
            style: {
                shape: 'rect',
                height: 48,
            },

            // set up the transaction
            createOrder: (data, actions) => {
                // pass in any options from the v2 orders create call:
                // https://developer.paypal.com/api/orders/v2/#orders-create-request-body
                const totalObj = $('#paypal-button-container')[0].dataset['amountToPay'];
                const createOrderPayload = {
                    purchase_units: [
                        {
                            amount: {
                                value: $(`#${totalObj}`).val(),
                            },
                        },
                    ],
                }

                return actions.order.create(createOrderPayload)
            },

            // finalize the transaction
            onApprove: (data, actions) => {
                const captureOrderHandler = (details) => {
                    const transaction = details.purchase_units[0].payments.captures[0];
                    const payerName = details.payer.name.given_name;
                    window.location.href = $('#paypal-button-container')[0].dataset['url']+`?transaction=${data.orderID}`;
                    console.log('Transaction completed!')
                }                   

                return actions.order.capture().then(captureOrderHandler)
            },

            // handle unrecoverable errors
            onError: (err) => {
                console.error(
                'An error prevented the buyer from checking out with PayPal',
                )
            },
        })

        if (paypalButtonsComponent.isEligible()) {
            paypalButtonsComponent
                .render('#paypal-button-container')
                .catch((err) => {
                    console.error('PayPal Buttons failed to render')
                })
        } else {
            console.log('The funding source is ineligible')
        }
    }
</script>
@endpush