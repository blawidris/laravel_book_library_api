<?php

namespace App\Http\Controllers;

use App\Billing\BankPaymentGateway;
use App\Contract\PaymentGatewayContract;
use App\Orders\OrderDetails;
use Illuminate\Http\Request;

class PayOrderController extends Controller
{
    public function store(OrderDetails $orderDetails, PaymentGatewayContract $gateway)
    {

        $order = $orderDetails->all();
        return $gateway->charge(2000);
    } 

    // public function store()
    // {

    //     $gateway = new PaymentGateway('usd');
    //     return $gateway->charge(2000);
    // }
}
