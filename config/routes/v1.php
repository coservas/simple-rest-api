<?php

return [
    [
        'methods' => ['get'],
        'name' => 'generate-start-dataset',
        'path' => '/generate-start-dataset',
        'handler' => App\Action\GenerateStartDatasetAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'create-order',
        'path' => '/order/create',
        'handler' => App\Action\Order\CreateAction::class,
    ],
    [
        'methods' => ['post'],
        'name' => 'pay-order',
        'path' => '/order/pay',
        'handler' => App\Action\Order\PayAction::class,
    ],
];
