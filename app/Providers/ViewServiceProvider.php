<?php

namespace App\Providers;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $cartItems = $user->CartItems;
                $view->with('cartItems', $cartItems);
            }

            $bookCategories = ProductCategory::where('status', 1)->get();
            $view->with('bookCategories', $bookCategories);
        });
    }
}
