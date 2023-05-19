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

use function Common\bloodTypeThrowFrom;

class Donors implements ControllerInterface
{
    /**
     * @throws InvalidBloodType
     */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        $type = bloodTypeThrowFrom($route->getParameter("type"));

        $blood = new Blood($type);

        $donors = array_map(static fn(BloodType $type) => $type->value, $blood->getPossibleDonors());

        return new JsonResponse($donors);
    }
}
