<?php

return [
    [
        'methods' => ['post'],
        'name' => 'generate-start-dataset',
        'path' => '/generate-start-dataset',
        'handler' => App\Action\Product\GenerateStartDatasetAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'product-list',
        'path' => '/products',
        'handler' => App\Action\Product\ListAction::class,
    ],
    [
        'methods' => ['get'],
        'name' => 'order-list',
        'path' => '/orders',
        'handler' => App\Action\Order\ListAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'order-create',
        'path' => '/orders',
        'handler' => App\Action\Order\CreateAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'order-pay',
        'path' => '/orders/{id}/pay',
        'handler' => App\Action\Order\PayAction::class,
    ],
];
