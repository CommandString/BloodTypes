<?php

namespace Twig\Functions;

use function Common\env;

abstract class TwigFunction
{
    abstract public static function getName(): string;

    abstract public static function call(): mixed;

    final public static function getMethod(): callable
    {
        return fn(...$args) => static::call(...$args);
    }

    public static function add()
    {
        env()->twig->addFunction(
            new \Twig\TwigFunction(
                static::getName(),
                static::getMethod()
            )
        );
    }
}
