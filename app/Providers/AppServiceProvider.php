<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderItems;
use App\Observers\OrderItemObserver;
use App\Observers\OrderObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        OrderItems::observe(OrderItemObserver::class);
        Order::observe(OrderObserver::class);
    }
}
