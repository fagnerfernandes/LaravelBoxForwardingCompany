<?php

namespace App\Enums;

use App\Traits\EnumsHelperTrait;

enum MailTemplateTypesEnum: int {

    use EnumsHelperTrait;

    case CREDIT_ADDED                       = 10;
    case CREDIT_USED                        = 11;
    case PACKAGE_RECEIVED                   = 20;
    case PACKAGE_DELIVERED                  = 21;
    case PURCHASE_AWAITING_PAYMENT          = 30;
    case PURCHASE_PAYED                     = 31;
    case ASSISTED_PURCHASE_APPROVED         = 40;
    case ASSISTED_PURCHASE_FINISHED         = 41;
    case ASSISTED_PURCHASE_CANCELED         = 42;

    public static function asText(MailTemplateTypesEnum $enum) {
        switch ($enum) {
            case self::CREDIT_ADDED:
                return 'Créditos: Adicionados';
                break;

            case self::CREDIT_USED:
                return 'Créditos: Usados';
                break;

            case self::PACKAGE_RECEIVED:
                return 'Pacote: Recebido';
                break;

            case self::PACKAGE_DELIVERED:
                return 'Pacote: Enviado';
                break;
            
            case self::PURCHASE_AWAITING_PAYMENT:
                return 'Compra: Aguardando Pagamento';
                break;
            
            case self::PURCHASE_PAYED:
                return 'Compra: Pagamento Efetivado';
                break;

            case self::ASSISTED_PURCHASE_APPROVED:
                return 'Compra Assitida: Aprovada para pagamento';
                break;
            
            case self::ASSISTED_PURCHASE_FINISHED:
                return 'Compra Assitida: Concluída';
                break;
        
            case self::ASSISTED_PURCHASE_CANCELED:
                return 'Compra Assitida: Cancelada';
                break;
        }
    }
}