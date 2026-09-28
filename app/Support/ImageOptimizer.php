<?php

namespace App\Support;

use Throwable;

class ImageOptimizer
{
    protected const MAX_WIDTHS = [
        'heroes' => 1920,
        'gallery' => 1600,
        'content' => 1400,
        'services' => 1000,
        'team' => 600,
        'testimonials' => 300,
        'avatars' => 300,
        'branding' => 400,
    ];

    protected const DEFAULT_MAX_WIDTH = 1600;

    protected const QUALITY = 80;

    public static function maxWidthFor(string $folder): int
    {
        return self::MAX_WIDTHS[$folder] ?? self::DEFAULT_MAX_WIDTH;
    }

    /**
     * Resize and recompress an image in place, keeping its path and format.
     * Returns true when the file was rewritten.
     */
    public static function optimize(string $path, int $maxWidth): bool
    {
        if (! extension_loaded('gd') || ! is_file($path)) {
            return false;
        }

        $info = @getimagesize($path);
        if (! $info) {
            return false;
        }

        [$width, $height, $type] = $info;

        if (! in_array($type, [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP], true)) {
            return false;
        }

        $originalSize = filesize($path);
        $previousLimit = ini_get('memory_limit');
        @ini_set('memory_limit', '512M');

        try {
            $image = match ($type) {
                IMAGETYPE_JPEG => @imagecreatefromjpeg($path),
                IMAGETYPE_PNG => @imagecreatefrompng($path),
                IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : false,
            };

            if (! $image) {
                return false;
            }

            if ($type === IMAGETYPE_JPEG) {
                $image = self::applyExifOrientation($image, $path);
                $width = imagesx($image);
                $height = imagesy($image);
            }

            $resized = false;
            if ($width > $maxWidth) {
                $newHeight = (int) round($height * $maxWidth / $width);
                $canvas = imagecreatetruecolor($maxWidth, $newHeight);

                if ($type !== IMAGETYPE_JPEG) {
                    imagealphablending($canvas, false);
                    imagesavealpha($canvas, true);
                }

                imagecopyresampled($canvas, $image, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $canvas;
                $resized = true;
            }

            $temp = $path.'.tmp';
            $written = match ($type) {
                IMAGETYPE_JPEG => imagejpeg($image, $temp, self::QUALITY),
                IMAGETYPE_PNG => imagepng($image, $temp, 9),
                IMAGETYPE_WEBP => imagewebp($image, $temp, self::QUALITY),
            };
            imagedestroy($image);

            if (! $written || ! is_file($temp)) {
                @unlink($temp);

                return false;
            }

            if (! $resized && filesize($temp) >= $originalSize) {
                @unlink($temp);

                return false;
            }

            return rename($temp, $path);
        } catch (Throwable) {
            @unlink($path.'.tmp');

            return false;
        } finally {
            @ini_set('memory_limit', $previousLimit);
        }
    }

    protected static function applyExifOrientation(\GdImage $image, string $path): \GdImage
    {
        if (! function_exists('exif_read_data')) {
            return $image;
        }

        $exif = @exif_read_data($path);
        $angle = match ((int) ($exif['Orientation'] ?? 1)) {
            3 => 180,
            6 => -90,
            8 => 90,
            default => 0,
        };

        if ($angle === 0) {
            return $image;
        }

        $rotated = imagerotate($image, $angle, 0);
        if (! $rotated) {
            return $image;
        }

        imagedestroy($image);

        return $rotated;
    }
}
