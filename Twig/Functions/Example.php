<?php

namespace Twig\Functions;

class Example extends TwigFunction
{
    public static function getName(): string
    {
        return "example";
    }

    public static function call(): mixed
    {
        return "Hi";
    }
}
