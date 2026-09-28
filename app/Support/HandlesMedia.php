<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesMedia
{
    protected function uploadImage(Request $request, string $field, string $folder, ?string $existing = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $existing;
        }

        if ($existing && Storage::disk('public')->exists($existing)) {
            Storage::disk('public')->delete($existing);
        }

        $path = $request->file($field)->store($folder, 'public');

        if ($path) {
            ImageOptimizer::optimize(Storage::disk('public')->path($path), ImageOptimizer::maxWidthFor($folder));
        }

        return $path;
    }

    protected function boolean(Request $request, string $field): bool
    {
        return $request->boolean($field);
    }
}
