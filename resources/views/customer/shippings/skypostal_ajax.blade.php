@php($total_extra_services = 0)
@if (count(session()->get('extra_services')))
    @foreach (session()->get('extra_services') as $service)
        @php($total_extra_services += $service['price'])
    @endforeach
    <!-- <strong>TOTAL: ${{ number_format($total_extra_services, 2) }}</strong> -->
    <?php $totalExtraServices = number_format($total_extra_services, 2);?>
@else
    <?php $totalExtraServices = 0;?>
@endif
<input type="hidden" name="company_tax" id="company_tax"  value="" />
<script>
    function shippingPrice(valueShipping, postalFee){
        $("#shipping_price").val(valueShipping);
        $('#postal_fee').val(postalFee);

        var totalWeightLast= $('#total_weight_final').val();
        var returnTheFee = returnFee(totalWeightLast, valueShipping);

            // //var fee = $('#company_tax').val();
            // var fee = returnTheFee;
            // var shippingPriceVal = (((valueShipping*fee)/100)+valueShipping)+<?php echo $totalExtraServices;?>;
            // $("#shippingPriceValue").val(shippingPriceVal);

    }

</script>


<input type="hidden" name="shipping_price" id="shipping_price" value="" required/>
<input type="hidden" name="price" id="shippingPriceValue" value="" required/>
<input type="hidden" name="extra_service" id="extra_service"  value="{{$totalExtraServices}}" />
<input type="hidden" name="postal_fee" id="postal_fee" value="">

@foreach ( $data as $key => $item)

<?php
$line = $key+301;
?>

<div class="col-6">
    <div class="card card-item panel-default">
        <!-- Default panel contents -->
        <div class="card-header text-center">
            <label for="option-{{ $line }}">Opção {{ ($line + 1) }}</label>
        </div>

        <div class="card-body">

            <p class="lead text-center"> @currency($item['total_value'])</p>
            <p class="text-center">

                <input type="hidden" name="shipping_estimate" value="30" />
                <em>Nome: {{$item['name_type']}}</em>
            </p>

            <p class="text-center mt-40">
                <label for="option-{{ $line }}">
                    <input required type="radio" id="option-{{ $line }}"
                    name="shipping_form_id" class="input-checkbox" value="{{ $line }}"
                    onclick="shippingPrice({{ $item['total_value'] }}, {{ $item['postal_fee'] }})"
                    />
                    Escolher esta opção
                </label>
            </p>
        </div>

    </div>
</div>


@endforeach

<script>
    function returnFee(total_weight_final, total_value){
        $.ajax({
            type:'POST',
            url:"/customer/shippings/fee",
            data:{total_weight_final:total_weight_final, total_value:total_value},
            success:function(data){
                $("#company_tax").val(data);
                //return data;
                //alert(data);
                var fee = $('#company_tax').val();
                var newFee = parseFloat(fee);

                var priceShip               = $("#shipping_price").val();
                var newPriceShip            = parseFloat(priceShip);
                var newTotalExtraServices   = parseFloat(<?php echo $totalExtraServices;?>);

                var shippingPriceVal = newPriceShip+newFee+newTotalExtraServices;
                $("#shippingPriceValue").val(shippingPriceVal);
            }
        });
    }
</script>
