<?php

namespace Twig\Functions;

class Entrypoint extends TwigFunction
{
    public static function getName(): string
    {
        return "entrypoint";
    }

    public static function call(string $name = ""): mixed
    {
        $entryPoints = __ASSETS__ . DIRECTORY_SEPARATOR . "entrypoints.json";

        if (!file_exists($entryPoints)) {
            throw new \RuntimeException("Cannot find {$entryPoints}");
        }

        $entryPoints = json_decode(file_get_contents($entryPoints))->entrypoints;

        if (!isset($entryPoints->{$name})) {
            throw new \InvalidArgumentException("{$name} is not a valid entry point");
        }

        $entrypoint = $entryPoints->{$name};

        $jsTemplate = "<script src='%s' defer></script>" . PHP_EOL;
        $cssTemplate = "<link rel='stylesheet' href='%s'>" . PHP_EOL;

        $return = "";

        foreach ($entrypoint->js as $path) {
            $return .= sprintf($jsTemplate, $path);
        }

        foreach ($entrypoint->css as $path) {
            $return .= sprintf($cssTemplate, $path);
        }

        return $return;
    }
}