<?php

namespace App\Service;

use App\Repository\CategoryItemRepository;

class GlobalService
{
    public function getRequestUri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }

    public function getRequestParams(): array
    {
        return $_GET;
    }
}
