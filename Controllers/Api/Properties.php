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

class Properties implements ControllerInterface
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

        $properties = [
            "proteins" => $blood->getProteins(),
            "antibodies" => $blood->getAntibodies()
        ];

        return new JsonResponse($properties);
    }
}
