<?php

use Common\Env;
use Tnapf\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function Common\getMimeFromExtension;

define("__ROOT__", realpath(__DIR__ . "/../"));
require __ROOT__ . '/App/Constants.php';
require __ROOT__ . '/vendor/autoload.php';

if (PHP_SAPI === "cli-server") {
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $path = pathinfo($url);
    if (!empty($path["extension"])) {
        $file_path = __PUBLIC__ . "{$path['dirname']}/{$path["basename"]}";

        if (file_exists($file_path)) {
            header("content-type: " . getMimeFromExtension($path["extension"]));
            readfile($file_path);
            return;
        }
    }
}

// Setup Environment
$env = Env::createFromEnv(__ROOT__ . "/.env");
$env->twig = new Environment(
    new FilesystemLoader([__ROOT__ . "/Views/"]),
    [
        "cache" => $env->DEV_MODE ? false : __ROOT__ . "/Cache",
        "debug" => $env->DEV_MODE
    ]
);
$env->router = new Router();

require_once __ROOT__ . '/App/Routes.php';
require_once __ROOT__ . '/App/TwigExtensions.php';

$env->router->emit();
