<?php

namespace App\Providers;

use App\Exports\VouchersExport;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Facades\Excel;

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
        //
    }
}
