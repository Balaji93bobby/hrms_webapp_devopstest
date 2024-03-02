<?php

namespace App\Providers;

use App\Interfaces\Payroll\VmtPayroll_RepInterface;
use App\Repositories\Payroll\VmtPayrollRepository;

use App\Interfaces\Payroll\Tally\VmtTallyPayroll_RepInterface;
use App\Repositories\Payroll\Tally\VmtTallyPayrollRepository;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VmtTallyPayroll_RepInterface::class, VmtTallyPayrollRepository::class);
        $this->app->bind(VmtPayroll_RepInterface::class, VmtPayrollRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'production')
        {
            URL::forceScheme('https');
        }

        Schema::defaultStringLength(191);


        Model::preventLazyLoading(! app()->isProduction());
    }
}
