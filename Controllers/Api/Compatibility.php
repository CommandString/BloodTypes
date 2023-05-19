<?php

namespace Controllers\Api;

use CommandString\Blood\Blood;
use Common\Exceptions\InvalidBloodType;
use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tnapf\Router\Interfaces\ControllerInterface;
use Tnapf\Router\Routing\RouteRunner;

use function Common\bloodTypeThrowFrom;

class Compatibility implements ControllerInterface
{
    /**
     * @throws InvalidBloodType
     */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RouteRunner $route
    ): ResponseInterface {
        $type1 = bloodTypeThrowFrom($route->getParameter("type1"));
        $type2 = bloodTypeThrowFrom($route->getParameter("type2"));

        $blood1 = new Blood($type1);
        $blood2 = new Blood($type2);

        $compatibility = [
            "can_donate_to" => $blood1->canDonateTo($blood2),
            "can_receive_from" => $blood1->canReceiveFrom($blood2)
        ];

        return new JsonResponse($compatibility);
    }
}
