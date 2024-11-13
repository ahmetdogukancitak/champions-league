<?php
namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\\Http\\Controllers'; // Namespace'i ekleyin
    
    public function boot()
    {
        $this->routes(function () {
            Route::middleware('api')
                ->namespace($this->namespace)  // Namespace'i ekleyin
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)  // Namespace'i ekleyin
                ->group(base_path('routes/web.php'));
        });
    }
}