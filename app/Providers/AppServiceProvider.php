<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

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
        // Compteur des commandes "en approche" pour la sidebar
        View::composer('layouts.app', function ($view) {
            $count = 0;
            $user = Auth::user();
            if ($user) {
                $agence = $user->pointRelais()->first();
                if ($agence) {
                    $count = Order::where('destination_point_relais_id', $agence->id)
                        ->whereIn('statut', [
                            Order::STATUT_EN_ATTENTE,
                            Order::STATUT_PAYE,
                            Order::STATUT_PRET,
                            Order::STATUT_EN_ROUTE,
                        ])
                        ->count();
                }
            }
            $view->with('sidebarIncomingCount', $count);
        });
    }
}
