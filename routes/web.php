<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WorkingHourController;
use App\Http\Controllers\Admin\StaffUserController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Staff\AuthController as StaffAuthController;
use App\Http\Controllers\Staff\JobController as StaffJobController;
use App\Http\Controllers\Staff\CustomerController as StaffCustomerController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\ServiceController as StaffServiceController;
use App\Http\Controllers\Staff\VisitController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/services', [SiteController::class, 'services'])->name('services.index');
Route::get('/services/{service:slug}', [SiteController::class, 'service'])->name('services.show');
Route::get('/gallery', [SiteController::class, 'gallery'])->name('gallery');
Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [FormController::class, 'contact'])->name('contact.store');
Route::get('/book', [SiteController::class, 'booking'])->name('booking');
Route::post('/book', [FormController::class, 'booking'])->name('booking.store');
Route::get('/p/{page:slug}', [SiteController::class, 'page'])->name('page.show');

Route::get('/ashen/{path?}', function (?string $path = '') {
    $root = realpath(base_path('ashen'));
    abort_unless($root !== false, 404);

    $relative = ltrim(str_replace('\\', '/', (string) $path), '/');
    $candidate = $root.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $relative);

    if ($relative === '' || is_dir($candidate)) {
        $candidate = rtrim($candidate, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.'index.html';
    }

    $file = realpath($candidate);
    $rootPrefix = strtolower($root).DIRECTORY_SEPARATOR;
    abort_unless(
        $file !== false
        && is_file($file)
        && str_starts_with(strtolower($file), $rootPrefix),
        404
    );

    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $mime = match ($extension) {
        'html' => 'text/html; charset=UTF-8',
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'json' => 'application/json',
        default => null,
    };

    if ($extension === 'html') {
        $html = file_get_contents($file);
        if (! str_contains(strtolower($html), '<base ')) {
            $html = preg_replace('/<head>/i', '<head><base href="/ashen/">', $html, 1) ?: $html;
        }

        return response($html, 200, ['Content-Type' => $mime]);
    }

    $headers = $mime ? ['Content-Type' => $mime] : [];
    $headers['Cache-Control'] = 'no-cache, must-revalidate';

    return response()->file($file, $headers);
})->where('path', '.*');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.store');
    });

        Route::middleware('auth')->group(function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        });

        Route::middleware(['auth', 'admin'])->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
        Route::put('sections', [SectionController::class, 'update'])->name('sections.update');

        Route::resource('heroes', HeroSlideController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);
        Route::resource('features', FeatureController::class)->except(['show']);
        Route::resource('stats', StatController::class)->except(['show']);
        Route::resource('team', TeamController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('gallery', GalleryController::class)->except(['show']);
        Route::resource('faqs', FaqController::class)->except(['show']);
        Route::resource('pages', PageController::class)->except(['show']);

        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::post('menus', [MenuController::class, 'store'])->name('menus.store');
        Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

        Route::get('hours', [WorkingHourController::class, 'index'])->name('hours.index');
        Route::put('hours', [WorkingHourController::class, 'update'])->name('hours.update');

        Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::put('bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('staff-users', [StaffUserController::class, 'index'])->name('staff.index');
        Route::get('staff-users/create', [StaffUserController::class, 'create'])->name('staff.create');
        Route::post('staff-users', [StaffUserController::class, 'store'])->name('staff.store');
        Route::get('staff-users/access', [StaffUserController::class, 'access'])->name('staff.access');
        Route::put('staff-users/access', [StaffUserController::class, 'updateAccess'])->name('staff.access.update');
        Route::get('staff-users/{staff}/edit', [StaffUserController::class, 'edit'])->name('staff.edit');
        Route::put('staff-users/{staff}', [StaffUserController::class, 'update'])->name('staff.update');
        Route::delete('staff-users/{staff}', [StaffUserController::class, 'destroy'])->name('staff.destroy');

        Route::get('customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');

        Route::get('jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::get('jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
        Route::get('jobs/{job}/invoice', [AdminJobController::class, 'invoice'])->name('jobs.invoice');
    });
});

Route::prefix('staff')->name('staff.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [StaffAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [StaffAuthController::class, 'login'])->name('login.store');
    });

    Route::middleware(['auth', 'staff'])->group(function () {
        Route::post('logout', [StaffAuthController::class, 'logout'])->name('logout');
        Route::get('/', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('services', [StaffServiceController::class, 'index'])->name('services.index');
        Route::get('services/{service}/register', [VisitController::class, 'create'])->name('visits.create');
        Route::post('services/{service}/register', [VisitController::class, 'store'])->name('visits.store');
        Route::get('customers/lookup', [StaffCustomerController::class, 'lookup'])->name('customers.lookup');
        Route::get('jobs', [StaffJobController::class, 'index'])->name('jobs.index');
        Route::get('jobs/create', [StaffJobController::class, 'create'])->name('jobs.create');
        Route::post('jobs', [StaffJobController::class, 'store'])->name('jobs.store');
        Route::get('jobs/{job}', [StaffJobController::class, 'show'])->name('jobs.show');
        Route::get('jobs/{job}/edit', [StaffJobController::class, 'edit'])->name('jobs.edit');
        Route::put('jobs/{job}', [StaffJobController::class, 'update'])->name('jobs.update');
        Route::delete('jobs/{job}', [StaffJobController::class, 'destroy'])->name('jobs.destroy');
        Route::post('jobs/{job}/invoice', [StaffJobController::class, 'invoice'])->name('jobs.invoice.store');
        Route::get('jobs/{job}/invoice', [StaffJobController::class, 'showInvoice'])->name('jobs.invoice');
        Route::post('jobs/{job}/paid', [StaffJobController::class, 'paid'])->name('jobs.paid');
    });
});
