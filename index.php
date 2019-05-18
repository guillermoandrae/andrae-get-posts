<?php

require __DIR__.'/vendor/autoload.php';

lambda(function (array $event) {
    return getJson('Hello ' . ($event['name'] ?? 'world'));
});
