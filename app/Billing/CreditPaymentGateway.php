<?php

namespace App\Billing;

use App\Contract\PaymentGatewayContract;
use Illuminate\Support\Str;

class CreditPaymentGateway implements PaymentGatewayContract
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

        $fees = $amount * 0.03;


        return [
            'amount' => $amount - $this->discount + $fees,
            'confirmation_number' => Str::random(),
            'currency' => $this->currency,
            'discount' => $this->discount,
            'fees' => $fees
        ];
    }
}