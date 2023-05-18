<?php

namespace Controllers\Api;

use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;
use Common\Exceptions\InvalidBloodType;
use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

use function strtoupper;

class Recipients implements ControllerInterface
{
    /**
     * @throws InvalidBloodType
     */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        $type = BloodType::throwFrom($route->getParameter("type"));

        $blood = new Blood($type);

        $recipients = array_map(static fn(BloodType $type) => $type->value, $blood->getPossibleRecipients());

        return new JsonResponse($recipients);
    }
}
