<?php

return [
    [
        'methods' => ['get'],
        'name' => 'login',
        'path' => '/login',
        'handler' => App\Action\Auth\LoginAction::class,
    ],
];
