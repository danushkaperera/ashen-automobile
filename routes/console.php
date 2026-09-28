<?php

use App\Support\ImageOptimizer;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('media:optimize', function () {
    $disk = Storage::disk('public');
    $before = 0;
    $after = 0;
    $optimized = 0;

    foreach ($disk->allFiles() as $file) {
        if (! preg_match('/\.(jpe?g|png|webp)$/i', $file)) {
            continue;
        }

        $path = $disk->path($file);
        $size = filesize($path);
        $folder = str_contains($file, '/') ? explode('/', $file)[0] : '';

        $before += $size;
        if (ImageOptimizer::optimize($path, ImageOptimizer::maxWidthFor($folder))) {
            clearstatcache(true, $path);
            $optimized++;
            $this->line(sprintf('%s: %d KB -> %d KB', $file, $size / 1024, filesize($path) / 1024));
        }
        $after += filesize($path);
    }

    $this->info(sprintf('Optimized %d images. Total %.1f MB -> %.1f MB', $optimized, $before / 1048576, $after / 1048576));
})->purpose('Resize and compress images already uploaded to the public disk');
