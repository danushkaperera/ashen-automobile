<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\GalleryItem;
use App\Models\HeroSlide;
use App\Models\MenuItem;
use App\Models\TeamMember;
use App\Models\WorkingHour;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Support\Settings::class);
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        Route::bind('hero', fn ($value) => HeroSlide::query()->findOrFail($value));
        Route::bind('team', fn ($value) => TeamMember::query()->findOrFail($value));
        Route::bind('gallery', fn ($value) => GalleryItem::query()->findOrFail($value));

        View::composer('layouts.public', function ($view) {
            if (! Schema::hasTable('menu_items')) {
                $view->with(['headerMenu' => collect(), 'footerMenu' => collect(), 'workingHours' => collect()]);

                return;
            }

            $view->with([
                'headerMenu' => MenuItem::location('header')->active()->get(),
                'footerMenu' => MenuItem::location('footer')->active()->get(),
                'workingHours' => WorkingHour::ordered()->get(),
            ]);
        });

        View::composer('layouts.admin', function ($view) {
            if (! Schema::hasTable('bookings')) {
                $view->with(['pendingBookings' => 0, 'unreadMessages' => 0]);

                return;
            }

            $view->with([
                'pendingBookings' => Booking::query()->where('status', 'pending')->count(),
                'unreadMessages' => ContactMessage::unread()->count(),
            ]);
        });
    }
}
