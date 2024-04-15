<?php

namespace App\Billing;

use App\Contract\PaymentGatewayContract;
use Illuminate\Support\Str;

class BankPaymentGateway implements PaymentGatewayContract
{
    private $discount;

    public function __construct(private $currency)
    {
        $this->discount = 0;
    }

    public function setDiscount($amount){
        $this->discount = $amount;
    }

    public function charge($amount){

        // charge the bank

        return [
            'amount' => $amount - $this->discount,
            'confirmation_number' => Str::random(),
            'currency' => $this->currency,
            'discount' => $this->discount
        ];
    }
}