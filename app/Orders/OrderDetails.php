<?php

namespace App\Orders;

use App\Contract\PaymentGatewayContract;

class OrderDetails 
{
    public function __construct(private PaymentGatewayContract $paymentGateway){

    }

    public function all(){
        $this->paymentGateway->setDiscount(100);


        return [
            'name' => 'Oriola David'
        ];
    }
}