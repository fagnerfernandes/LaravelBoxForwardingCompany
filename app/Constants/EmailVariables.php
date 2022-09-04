<?php

namespace App\Constants;

use App\Enums\DataFormatTypesEnum;

class EmailVariables {

    public const CUSTOMER = [
        [
            'label'     => 'Cliente: Nome',
            'name'      => 'CLIENTE.NOME',
            'field'     => 'name',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'     => 'Cliente: Número CPF',
            'name'      => 'CLIENTE.CPF',
            'field'     => 'userable.document',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'     => 'Cliente: E-mail',
            'name'      => 'CLIENTE.EMAIL',
            'field'     => 'email',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'     => 'Cliente: Telefone',
            'name'      => 'CLIENTE.TELEFONE',
            'field'     => 'phone_number',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ], 
        [
            'label'     => 'Cliente: Link Afiliado',
            'name'      => 'CLIENTE.LINK-AFILIADO',
            'field'     => 'userable.affiliate_token',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ], 
        [
            'label'     => 'Cliente: Suite',
            'name'      => 'CLIENTE.SUITE',
            'field'     => 'userable.suite',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ]
    ];
    
    public const SHIPPING = [
        [
            'label'      => 'Envio: Nome do Envio',
            'name'       => 'ENVIO.NOME',
            'field'      => 'name',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ], 
        [
            'label'      => 'Envio: Código de Rastreio',
            'name'       => 'ENVIO.CODIGO-RASTREIO',
            'field'      => '',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ], 
        [
            'label'      => 'Envio: Quantidade Itens',
            'name'       => 'ENVIO.QUANTIDADE-ITENS',
            'field'      => '',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ], 
        [
            'label'      => 'Envio: Valor Envio',
            'name'       => 'ENVIO.VALOR-ENVIO',
            'field'      => '',
            'format'    => DataFormatTypesEnum::CURRENCY
        ], 
        [
            'label'      => 'Envio: Valor Envio Declarado',
            'name'       => 'ENVIO.VALOR-ENVIO-DECLARADO',
            'field'      => '',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],  
    ];
    
    public const ADDRESS = [
        [
            'label'      => 'Endereço: Nome',
            'name'       => 'ENDERECO.NOME',
            'field'      => 'name',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: CEP',
            'name'       => 'ENDERECO.CEP',
            'field'      => 'postal_code',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Rua',
            'name'       => 'ENDERECO.RUA',
            'field'      => 'street',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Número',
            'name'       => 'ENDERECO.NUMERO',
            'field'      => 'number',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Complemento',
            'name'       => 'ENDERECO.COMPLEMENTO',
            'field'      => 'number',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Bairro',
            'name'       => 'ENDERECO.BAIRRO',
            'field'      => 'district',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Cidade',
            'name'       => 'ENDERECO.CIDADE',
            'field'      => 'city',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Endereço: Estado',
            'name'       => 'ENDERECO.ESTADO',
            'field'      => 'state',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ]
    ];

    public const PURCHASE = [
        [
            'label'      => 'Compra: Valor',
            'name'       => 'COMPRA.VALOR',
            'field'      => 'value',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra: Data',
            'name'       => 'COMPRA.DATA',
            'field'      => 'created_at',
            'format'    => DataFormatTypesEnum::DATETIME
        ],
        [
            'label'      => 'Compra: Status',
            'name'       => 'COMPRA.STATUS',
            'field'      => 'purchase_status.description',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra: Formas de Pagamento',
            'name'       => 'COMPRA.FORMAS-PAGAMENTO',
            'type'       => 'list',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ]
    ];

    public const PAYMENT = [
        [
            'label'      => 'Pagamento: Forma de Pagamento',
            'name'       => 'PAGAMENTO.FORMA-PAGAMENTO',
            'field'      => 'payment_method',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Pagamento: Valor',
            'name'       => 'PAGAMENTO.VALOR',
            'field'      => 'value',
            'format'    => DataFormatTypesEnum::CURRENCY
        ]
    ];

    public const PACKAGE = [
        [
            'label'      => 'Pacote: Nome',
            'name'       => 'PACOTE.NOME',
            'field'      => 'name',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Pacote: SKU',
            'name'       => 'PACOTE.SKY',
            'field'      => 'sku',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Pacote: Localização',
            'name'       => 'PACOTE.LOCALIZACAO',
            'field'      => 'location',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        
        [
            'label'      => 'Pacote: Peso',
            'name'       => 'PACOTE.PESO',
            'field'      => 'weight',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Pacote: Foto',
            'name'       => 'PACOTE.FOTO',
            'field'      => 'photo',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Pacote: Código de Rastreio',
            'name'       => 'PACOTE.CODIGO-RASTREIO',
            'field'      => 'tracking_code',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ]
    ];

    public const CREDIT = [
        [
            'label'      => 'Créditos: Valor',
            'name'       => 'CREDITOS.VALOR',
            'field'      => 'amount',
            'format'    => DataFormatTypesEnum::CURRENCY
        ],
        [
            'label'      => 'Créditos: Descrição',
            'name'       => 'CREDITOS.DESCRICAO',
            'field'      => 'description',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Créditos: Saldo Anterior',
            'name'       => 'CREDITOS.SALDO-ANTERIOR',
            'type'       => 'calc',
            'format'    => DataFormatTypesEnum::CURRENCY
        ],
        [
            'label'      => 'Créditos: Saldo Atual',
            'name'       => 'CREDITOS.SALDO-ATUAL',
            'type'       => 'calc',
            'format'    => DataFormatTypesEnum::CURRENCY
        ],
    ];

    public const ASSISTED_PURCHASE = [
        [
            'label'      => 'Compra Assistida: Titulo',
            'name'       => 'COMPRA-ASSISTIDA.TITULO',
            'field'      => 'title',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Link do Produto',
            'name'       => 'COMPRA-ASSISTIDA.LINK-PRODUTO',
            'field'      => 'link',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Cor',
            'name'       => 'COMPRA-ASSISTIDA.COR',
            'field'      => 'color',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Segunda Opção de Cor',
            'name'       => 'COMPRA-ASSISTIDA.COR-SECUNDARIA',
            'field'      => 'color_optional',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Tamanho',
            'name'       => 'COMPRA-ASSISTIDA.TAMANHO',
            'field'      => 'size',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Segunda Opção de Tamanho',
            'name'       => 'COMPRA-ASSISTIDA.TAMANHO-SECUNDARIO',
            'field'      => 'size_optional',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Preço',
            'name'       => 'COMPRA-ASSISTIDA.PRECO',
            'field'      => 'price',
            'format'    => DataFormatTypesEnum::CURRENCY
        ],
        [
            'label'      => 'Compra Assistida: Quantidade',
            'name'       => 'COMPRA-ASSISTIDA.QUANTIDADE',
            'field'      => 'quantity',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
        [
            'label'      => 'Compra Assistida: Link para Pagamento',
            'name'       => 'COMPRA-ASSISTIDA.LINK-PAGAMENTO',
            'type'      => 'calc',
            'format'    => DataFormatTypesEnum::UNFORMATED
        ],
    ];
}

