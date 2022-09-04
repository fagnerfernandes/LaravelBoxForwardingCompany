@extends('layouts.app')

@section('title')
    Escolha o método de envio
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('customer.shippings.index') }}">Meus envios</a></li>
    <li class="active"><span>Escolha o método de envio</span></li>
@endsection

@section('wrapper')
    <form action="{{ route('customer.shippings.methodPost') }}" method="POST">
        @csrf

        <input type="hidden" id="total_weight_items" value="{{ number_format(session()->get('weight.items'), 2) }}" />
        <input type="hidden" id="total_weight_services" value="{{ number_format(session()->get('weight.services'), 2) }}" />
        <input type="hidden" id="total_weight_final" value="{{ number_format(($total_weight + $packages[0]['weight']), 2) }}" />
        <input type="hidden" id="total_declarado" name="total_declarado" value="" />

        <div class="row">
            <!-- Basic Table -->
            <div class="col-sm-12">

                @include('customer.shippings.steps', ['step' => 5])

                <div class="card round-10 w-100">
                    <div class="card-header">
                        <h6 class="panel-title txt-dark"><i class="zmdi zmdi-airplane"></i> Escolha o método de envio</h6>
                    </div>

                    <div class="card-body">
                        <!-- Basic Table -->

                        <h4 class="mb-3">Peso total: <span id="total_final">{{ number_format(($total_weight + $packages[0]['weight']), 2) }}</span> lbs</h4>

                        <fieldset>
                            <legend class="fs-6">Escolha o tipo de pacote</legend>

                            <div class="row mb-3">
                                {{-- {{ dd($packages) }} --}}
                                @foreach ($packages as $key => $package)
                                    
                                    <div class="col-md-6">
                                        <div class="card card-package {{ ($package['default']) ? 'item-selected' : '' }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <h5 class="card-title">
                                                        <label for="package-{{ $key }}">{{ $package['name'] }}</label>
                                                    </h5>
                                                    <input type="radio" id="package-{{ $key }}" name="package_id" value="{{ $package['name'] }}" class="input-checkpackage" required {{ ($package['default']) ? 'checked="checked"' : '' }} />
                                                </div>
                                                <p class="card-text">
                                                    <label for="package-{{ $key }}">
                                                        <strong>Peso adicional: </strong>
                                                        <span class="weight_package">{{ number_format($package['weight'], 2) }}</span> lbs
                                                        <br />
                                                        {{-- <strong>Preço: </strong>$ {{ number_format($package['price'], 2) }} --}}
                                                    </label>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>

                        {{-- Solicitar seguro ou nao --}}
                        <fieldset>
                            <legend class="fs-6">Gostaria de segurar o valor declarado</legend>
                            <div class="row">
                                <div class="col-4">
                                    <div class="row" id="seguro">
                                        <div class="row">
                                            <div class="col-8">
                                                Valor total declarado:
                                            </div>
                                            <div id="valor_total_declarado" class="col-4">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                Valor do seguro:
                                            </div>
                                            <div id="calculo_seguro" class="col-4">

                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <select name="insurance" class="form-control">
                                                    <option value="0">NÃO quero seguro</option>
                                                    <option value="1">SIM, eu quero seguro</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />

                        </fieldset>

                        {{-- Lista as opções de frete --}}
                        <fieldset>
                            <legend class="fs-6">Escolha a opção de envio</legend>
                            <div class="row">
                                <!-- <div class="col-6">
                                    <div class="row" id="usps_ajax">

                                    </div>
                                </div> -->
                                <div class="col-12">
                                    <div class="row" id="skypostal_ajax">

                                    </div>
                                </div>
                                {{-- <livewire:shipping-quote :weight="$total_weight + $packages[0]['weight']" :unit="'LB'"/> --}}
                            </div>

                        </fieldset>

                        <hr />
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> voltar</a>
                            <button type="submit" class="btn btn-primary">
                                Finalizar <i class="bx bx-check"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <x-modal-plastic-bag-warning></x-modal-plastic-bag-warning>
@endsection

@section('scripts')
<style>
    .item-selected {
        border: 1px solid #0a4e0a;
        background: #d9f7d9;
    }
</style>
<script>

    $(function() {
        let totalFinal = parseFloat($('#total_weight_final').val())
        let weightItems = parseFloat($('#total_weight_items').val())
        let weightServices = parseFloat($('#total_weight_services').val())

        <?php
        if(isset($packages[0]['weight'])){
            ?>
            //returnUsps(totalFinal + <?php echo $packages[0]['weight'];?>);
            //returnSkypostal(totalFinal + <?php echo $packages[0]['weight'];?>);
            returnSkypostal(totalFinal);
            <?php
        }
        ?>

        //console.log(`total final: ${totalFinal}\n peso dos itens: ${weightItems}\n peso dos serviços: ${weightServices}`)

        $('.input-checkbox').on('click', function() {
            $('.card-item').each(function() {
                $(this).removeClass('item-selected')
            })
            $(this).parents('.card-item').addClass('item-selected')
            //returnUsps();
            returnSkypostal();
        })

        $('.input-checkpackage').on('click', function() {
            $('.card-package').each(function() {
                $(this).removeClass('item-selected')
            })
            $(this).parents('.card-package').addClass('item-selected')

            let packageWeight = parseFloat($(this).parents('.card-package').find('.weight_package').text())
            totalFinal = (weightItems + weightServices + packageWeight)

            $('#total_final').html(Intl.NumberFormat('pt-BR', { maximumFractionDigits: 2, minimumFractionDigits: 2 }).format(totalFinal))
            $("#total_weight_final").val(totalFinal);

            if ($(this).val() == 'Saco Plástico') {
                $('#modalPlasticBagWarning').modal('show')
            }
            //returnUsps(totalFinal);
            returnSkypostal(totalFinal);
        })
    })
</script>

@php($total = 0)
@php($total_declaration_amount = 0)
@php($total_value = 0)
@php($total_quantity = 0)
@foreach (session()->get('items') as $item)


    @php($total += $item['weight']*$item['quantity'])
    @php($total_declaration_amount += $item['declaration_amount'])
    @php($total_value += $item['value'])
    @php($total_quantity += $item['quantity'])
@endforeach

<?php
    $postal_code = session()->get('address')['postal_code'];

    $postal_code2 = str_replace("-", "", $postal_code);
    $postal_code3 = str_replace(".", "", $postal_code2);
?>

<script type="text/javascript">

    var totalValorASerSegurado = '<?php echo '$ ' . number_format($total_value, 2);?>';
    $("#valor_total_declarado").html('<?php echo (new \NumberFormatter(config('app.locale', 'en'), \NumberFormatter::CURRENCY))->formatCurrency($total_value, 'USD'); ?>');
    $("#total_declarado").val('<?php echo $total_value;?>');


     var calculo_seguro =  <?php echo $total_value;?>/100*0.4;
    $("#calculo_seguro").html('<?php echo (new \NumberFormatter(config('app.locale', 'en'), \NumberFormatter::CURRENCY))->formatCurrency(($total_value/100)*.4, 'USD'); ?>');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function returnUsps(totalFinal){

        $("#usps_ajax").html('<img src="../../img/spin.gif" alt="loading" style="width:200px; margin: 0 auto;" />');

        //var total_weight_final = $("#total_weight_final").val();
        var total_weight_final =  totalFinal;
        var total_value = '<?php echo $total_value;?>';
        var postal_code = '<?php echo $postal_code3;?>';

        var country = 'Brazil';

        $.ajax({
            type:'POST',
            url:"/customer/shippings/usps",
            data:{total_weight_final:total_weight_final, total_value:total_value,
                postal_code: postal_code, country: country},
            success:function(data){
                $("#usps_ajax").html(data);
                //alert(data);
            }
        });

    }

    function returnSkypostal(totalFinal){

        $("#skypostal_ajax").html('<img src="../../img/spin.gif" alt="loading" style="width:200px; margin: 0 auto;" />');

        var total_weight_final =  totalFinal;
        var total_value = '<?php echo $total_value;?>';
        var postal_code = '<?php echo $postal_code3;?>';

        var country = 'Brazil';

        $.ajax({
            type:'POST',
            url:"/customer/shippings/skypostal",
            data:{total_weight_final:total_weight_final, total_value:total_value,
                postal_code: postal_code, country: country},
            success:function(data){
                $("#skypostal_ajax").html(data);
                //alert(data);
            }
        });

        //fee(total_weight_final, total_value);

    }

    // function fee(total_weight_final, total_value){
    //     $.ajax({
    //         type:'POST',
    //         url:"/customer/shippings/fee",
    //         data:{total_weight_final:total_weight_final, total_value:total_value},
    //         success:function(data){
    //             $("#company_tax").val(data);
    //             //alert(data);
    //         }
    //     });
    // }
</script>

@endsection
