<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\DispatchController;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $counts = DispatchController::getSidebarCounts();
            $view->with('dispatchCounts', $counts);
        });
    }
}
