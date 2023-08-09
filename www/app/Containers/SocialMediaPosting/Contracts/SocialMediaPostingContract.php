<?php

declare(strict_types=1);

namespace App\Containers\SocialMediaPosting\Contracts;

interface SocialMediaPostingContract
{
    public function post(): void;
}
