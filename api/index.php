<?php

$directories = [
    '/tmp/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/app/public',
];

foreach ($directories as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
}

require __DIR__.'/../public/index.php';
