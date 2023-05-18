<?php

use Common\Env;
use Common\Exceptions\InvalidBloodType;
use Controllers\Api\Compatibility;
use Controllers\Api\Donors;
use Controllers\Api\Properties;
use Controllers\Api\Recipients;
use Controllers\Basic\Render;
use HttpSoft\Response\JsonResponse;
use HttpSoft\Response\TextResponse;

$router = Env::get()->router;

$router->get("/", new Render("home"));

$router->group("/api", static function ($router) {
    $router->get("/compatibility/{type1}/{type2}", new Compatibility());
    $router->get("/donors/{type}", new Donors());
    $router->get("/recipients/{type}", new Recipients());
    $router->get("/properties/{type}", new Properties());
});

$router->catch(
    InvalidBloodType::class,
    static function () {
        return new JsonResponse([
            "error" => "Invalid blood type"
        ], 400);
    },
    "/api/(.*)"
);

$router->catch(
    Throwable::class,
    static fn($response, $request, $route) =>
        new TextResponse($route->exception->getMessage() . "\n\n" . $route->exception->getTraceAsString())
);
