<?php

namespace App\Providers;

use App\Billing\BankPaymentGateway;
use App\Billing\CreditPaymentGateway;
use App\Contract\PaymentGatewayContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentGatewayContract::class, function($app){

            if(request()->has('credit')){

                return new CreditPaymentGateway('usd');
            }
            
            return new BankPaymentGateway('euro');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
