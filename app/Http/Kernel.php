<?php

protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\VerifyCsrfToken::class, // Esta línea es clave
    ],

    'api' => [
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
?>