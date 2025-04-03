<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: 'php-info', name: 'php_info', methods: ['GET'])]
final readonly class PhpInfoAction
{
    public function __invoke(): Response
    {
        ob_start();
        phpinfo();
        $info = ob_get_clean();
        \assert(false !== $info);

        return new Response($info);
    }
}
