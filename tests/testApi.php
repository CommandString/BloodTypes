<?php

namespace tests;

use CommandString\Blood\Enums\BloodType;
use Common\Env;
use Common\Exceptions\InvalidBloodType;
use Controllers\Api\Compatibility;
use Controllers\Api\Donors;
use Controllers\Api\InvalidBloodTypeCatch;
use Controllers\Api\Properties;
use Controllers\Api\Recipients;
use HttpSoft\Message\Request;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Tnapf\Router\Router;

use function json_decode;

class testApi extends TestCase
{
    protected bool $routesRegistered = false;
    protected Router $router;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->registerRoutes();
    }

    public function registerRoutes(): void
    {
        if ($this->routesRegistered) {
            return;
        }

        $this->router = new Router();

        $this->router->group("/api", static function (Router $router) {
            $router->get("/compatibility/{type1}/{type2}", new Compatibility());
            $router->get("/donors/{type}", new Donors());
            $router->get("/recipients/{type}", new Recipients());
            $router->get("/properties/{type}", new Properties());
            $router->catch(InvalidBloodType::class, new InvalidBloodTypeCatch());
        });
    }

    public function sendRequest(string $uri, string $method = "GET"): array
    {
        $request = new ServerRequest(method: $method, uri: $uri);

        $response = $this->router->run($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function testPropertiesEndpoint(): void
    {
        $response = $this->sendRequest("/api/properties/A+");

        $this->assertEquals(
            [
                "proteins" => [
                    "A",
                    "RH"
                ],
                "antibodies" => [
                    "B"
                ]
            ],
            $response
        );
    }

    public function testCompatibilityEndpoint(): void
    {
        $response = $this->sendRequest("/api/compatibility/O-/A+");

        $this->assertEquals(
            [
                "can_donate_to" => true,
                "can_receive_from" => false
            ],
            $response
        );
    }

    public function testDonorsEndpoint(): void
    {
        $response = $this->sendRequest("/api/donors/A+");

        $this->assertEquals(
            ["A-", "A+", "O-", "O+"],
            $response
        );
    }

    public function testRecipientsEndpoint(): void
    {
        $response = $this->sendRequest("/api/recipients/A+");

        $this->assertEquals(
            ["A+", "AB+"],
            $response
        );
    }

    public function testAllEndpointsDontAcceptABadBloodType(): void
    {
        $uris = [
            "/api/properties/:type",
            "/api/compatibility/:type/:type",
            "/api/donors/:type",
            "/api/recipients/:type"
        ];

        foreach ($uris as $uri) {
            $response = $this->sendRequest($uri);

            $this->assertEquals([
                "error" => "Invalid blood type"
            ], $response);
        }
    }
}
