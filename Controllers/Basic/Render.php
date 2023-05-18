<?php

namespace Controllers\Basic;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

use function Common\render;

class Render implements ControllerInterface
{
    public function __construct(
        public readonly string $path,
        public readonly array $context = [],
        public readonly int $code = 200
    ) {
    }

    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        return render($this->path, $this->context, $this->code);
    }
}
