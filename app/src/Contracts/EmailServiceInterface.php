<?php

declare(strict_types=1);

namespace App\Contracts;

interface EmailServiceInterface
{
    public function sendEmails(array $users, string $message): void;
}
