<?php

declare(strict_types=1);

namespace App\Entity;

class User
{
    private int $id;
    private string $login;

    public function getId(): int
    {
        return 1;
    }

    public function getLogin(): string
    {
        return 'admin';
    }
}
