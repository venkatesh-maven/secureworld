<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
      use App\Models\serviceTickets;
use App\Observers\ServiceTicketObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
  


    serviceTickets::observe(ServiceTicketObserver::class);


    }
}
