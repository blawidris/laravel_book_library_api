<?php

namespace App\Contract;


interface PaymentGatewayContract 
{
    public function charge($amount);
    public function setDiscount($amount);
}