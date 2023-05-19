<?php

namespace Controllers\Api;

use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

class InvalidBloodTypeCatch implements ControllerInterface
{
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        return new JsonResponse(
            [
                "error" => "Invalid blood type"
            ],
            400
        );
    }
}
