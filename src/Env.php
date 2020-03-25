<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;

class Env
{
    private const PATH = '.';
    private const BASE_ENV_NAME = '.env';
    private const LOCAL_ENV_NAME = '.env.local';

    public static function load(): void
    {
        $dotenv = Dotenv::createMutable(self::PATH, self::BASE_ENV_NAME);
        $dotenv->load();

        $pathname = self::PATH . DIRECTORY_SEPARATOR . self::LOCAL_ENV_NAME;
        if (file_exists($pathname)) {
            $dotenv = Dotenv::createMutable(self::PATH, self::LOCAL_ENV_NAME);
            $dotenv->load();
        }
    }
}
