protected $middlewareGroups = [
    'web' => [
        // middleware lainnya...
        \App\Http\Middleware\CacheSyncMiddleware::class,
    ],
];