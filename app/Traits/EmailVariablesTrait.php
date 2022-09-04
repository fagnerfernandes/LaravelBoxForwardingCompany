<?php

namespace App\Traits;

use App\Constants\EmailVariables;
use App\Enums\MailTemplateTypesEnum;
use App\Enums\DataFormatTypesEnum;
use App\Models\Address;
use App\Models\AssistedPurchase;
use App\Models\Credit;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Shipping;
use App\Models\User;
use Carbon\Carbon;
use DebugBar\DataFormatter\DataFormatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use NumberFormatter;
use PhpParser\Node\Stmt\TryCatch;

trait EmailVariablesTrait {
    public function getVariables(MailTemplateTypesEnum $mailType) {
        try {
            switch ($mailType) {
                case $mailType::PACKAGE_RECEIVED:
                    return array_merge(EmailVariables::CUSTOMER, EmailVariables::PACKAGE);
                    break;

                case $mailType::PACKAGE_DELIVERED:
                    return array_merge(EmailVariables::CUSTOMER, EmailVariables::ADDRESS, EmailVariables::SHIPPING);
                    break;
    
                case $mailType::CREDIT_ADDED:
                case $mailType::CREDIT_USED:
                    return array_merge(EmailVariables::CUSTOMER, EmailVariables::PURCHASE, EmailVariables::CREDIT);
                    break;
    
                case $mailType::PURCHASE_AWAITING_PAYMENT:
                case $mailType::PURCHASE_PAYED:
                    return array_merge(EmailVariables::CUSTOMER, EmailVariables::PURCHASE/* , EmailVariables::PAYMENT */);
                    break;

                case $mailType::ASSISTED_PURCHASE_APPROVED:
                case $mailType::ASSISTED_PURCHASE_FINISHED:
                case $mailType::ASSISTED_PURCHASE_CANCELED:
                    return array_merge(EmailVariables::CUSTOMER, EmailVariables::ASSISTED_PURCHASE);
                    break;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function template_substitution($template, $data) {
        try {
            $placeholders = array_map(fn($placeholder) => strtoupper("{{$placeholder}}"), array_keys($data));
            return strtr($template, array_combine($placeholders, $data));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getCustomerData(User $user) {
        try {
            $customer = $this->getData(
                EmailVariables::CUSTOMER, 
                Arr::dot(
                    $user->load('userable')->toArray()
                )
            );
    
            // Obtem a rota do Link de afiliado de acordo com o token de afiliado do usuário
            $customer['CLIENTE.LINK-AFILIADO'] = route('register', ['af' => $customer['CLIENTE.LINK-AFILIADO']]);
    
            return $customer;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getAddressData(Address $address): array {
        try {
            return $this->getData(
                EmailVariables::ADDRESS, 
                Arr::dot(
                    $address->toArray()
                )
            );
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getShippingData(Shipping $shipping): array {
        try {
            return $this->getData(
                EmailVariables::SHIPPING, 
                Arr::dot(
                    $shipping->toArray()
                )
            );
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getPurchaseData(Purchase $purchase): array {
        try {
            $purchaseArray = $this->getData(
                EmailVariables::PURCHASE,
                Arr::dot(
                    $purchase->load('purchaseStatus')->toArray()
                )
            );
            foreach($purchase->payments as $payment) {
                $purchaseArray['COMPRA.FORMAS-PAGAMENTO'][] = $this->getPaymentData($payment);
            }
    
            return $purchaseArray;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getPaymentData(Payment $payment): array {
        try {
            return $this->getData(
                EmailVariables::PAYMENT,
                Arr::dot(
                    $payment->toArray()
                )
            );
        } catch (\Exception $exception) {
            throw $exception;
        }
    } 

    public function getPackageData(Package $package): array {
        try {
            return $this->getData(
                EmailVariables::PACKAGE,
                Arr::dot(
                    $package->toArray()
                )
            );
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getCreditData(Credit $credit): array {
        try {
            $creditArray = $this->getData(
                EmailVariables::CREDIT,
                Arr::dot(
                    $credit->toArray()
                )
            );
    
            $saldoAtual = $credit->user->creditBalance();
            $saldoAnterior = $saldoAtual + ($credit->type == 'out' ? $credit->amount : $credit->amount * -1); 
            $creditArray['CREDITOS.SALDO-ATUAL'] =  $this->formatCurrency($saldoAtual);
            $creditArray['CREDITOS.SALDO-ANTERIOR'] = $this->formatCurrency($saldoAnterior);
    
            return $creditArray;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getAssistedPurchaseData(AssistedPurchase $assistedPurchase): array {
        try {
            $assistedPurchaseArray = $this->getData(
                EmailVariables::ASSISTED_PURCHASE,
                Arr::dot(
                    $assistedPurchase->load('user')->toArray()
                )
            );
    
            $assistedPurchaseArray['COMPRA-ASSISTIDA.LINK-PAGAMENTO'] = route('customer.assisted-purchases.show', ['assisted_purchase', $assistedPurchase]);
    
            return $assistedPurchaseArray;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getData(array $variables, array $data): array {
        try {
            $result = [];
            foreach ($variables as $variable) {
                if (!isset($variable['type']) || !in_array($variable['type'], ['list', 'calc'])) {
                    $result[$variable['name']] = $this->getFormatedData($variable['format'], $data[$variable['field']]);
                }
            } 
    
            return $result;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function formatCurrency($value): string {
        try {
            return (new \NumberFormatter(config('app.locale', 'en'), \NumberFormatter::CURRENCY))->formatCurrency(floatval($value), 'USD');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function formatDateTime($data): string {
        try {
            return Carbon::parse($data)->format('d/m/Y H:i:s');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    
    public function formatDate($data): string {
        try {
            return Carbon::parse($data)->format('d/m/Y');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
    
    public function formatTime($data): string {
        try {
            return Carbon::parse($data)->format('H:i:s');
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getFormatedData(DataFormatTypesEnum $type, $value): string {
        try {
            switch ($type) {
                case DataFormatTypesEnum::UNFORMATED:
                    
                    return strval($value);
                    break;
    
                case DataFormatTypesEnum::CURRENCY:
                    return $this->formatCurrency(floatval($value));
                    break;
    
                case DataFormatTypesEnum::DATETIME:
                    return $this->formatDateTime($value);
                    break;
                
                case DataFormatTypesEnum::DATE:
                    return $this->formatDate($value);
                    break;
            
                case DataFormatTypesEnum::TIME:
                    return $this->formatTime($value);
                    break;
            }
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}