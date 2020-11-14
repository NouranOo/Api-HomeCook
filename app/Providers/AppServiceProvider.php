<?php

namespace App\Providers;

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
        $this->app->bind(\Illuminate\Contracts\Routing\ResponseFactory::class, function () {
            return new \Laravel\Lumen\Http\ResponseFactory();
        });
        //
//         $this->app->singleton('mailer', function ($app) {
//             $app->configure('services');
//             return $app->loadComponent('mail', 'Illuminate\Mail\MailServiceProvider', 'mailer');
//             });
//   // Enable pagination
//         if (!Collection::hasMacro('paginate')) {

//             Collection::macro('paginate', 
//                 function ($perPage = 5, $page = null, $options = []) {
//                 $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
//                 return (new LengthAwarePaginator(
//                     $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
//                     ->withPath('');
//             });
//         }
    }
}
