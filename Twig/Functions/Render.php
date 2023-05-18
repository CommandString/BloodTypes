<?php

namespace Twig\Functions;

use function Common\renderHtml;

class Render extends TwigFunction
{
    public static function getName(): string
    {
        return "render";
    }

    public static function call(string $path = "", array $context = []): mixed
    {
        return renderHtml($path, $context);
    }
}
