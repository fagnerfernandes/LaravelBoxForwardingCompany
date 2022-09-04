<?php
if(1+1==3){
?>
@foreach ( $data as $key => $item)

    <?php
        //listamos apenas os tipos de envios pre-definidos
        if (
        str_contains($item['SvcDescription'], 'Priority Mail Express International') ||
         str_contains($item['SvcDescription'], 'Priority Mail International') //essa
        //|| str_contains($item['SvcDescription'], 'Global Express Guaranteed')
        //|| str_contains($item['SvcDescription'], 'First-Class Package International Service') //essa
        ) {
           ?>

    <div class="col-6">
        <div class="card card-item panel-default">
            <!-- Default panel contents -->
            <div class="card-header text-center">
                <label for="option-{{ $key }}>Opção {{ ($key + 1) }}</label>
            </div>

            <div class="card-body">

                <input type="hidden" name="shipping_price" value="{{$item['Postage']}}" />
                <p class="lead text-center"> $ {{$item['Postage']}}</p>
                <p>
                nome: {{$item['SvcDescription']}}
                </p>
                <p class="text-center">

                    <input type="hidden" name="shipping_estimate" value="{{$item['SvcCommitments']}}" />
                    <em>{{$item['SvcCommitments']}}</em>
                </p>
                <p class="text-center">
                    <em>serviços extras: A FAZER</em>
                </p>
                <p class="text-center">

                    <input type="hidden" name="company_tax" value="00000000" />
                    <em>taxa COMPANY: A FAZER</em>
                </p>
                <p class="lead text-center">
                    Total A FAZER
                </p>

                <p class="text-center mt-40">
                    <label for="option-{{ $key }}">
                        <input type="hidden" name="price" value="{{$item['Postage']}}" />
                        <input required type="radio" id="option-{{ $key }}" name="shipping_form_id" class="input-checkbox" value="{{ $key }}" />
                        Escolher esta opção
                    </label>
                </p>
            </div>

        </div>
    </div>


    <?php
        }
    ?>
<?php
// echo '<pre>';
// var_dump($item);
// echo '<pre>';

?>

@endforeach
<?php
}
?>
