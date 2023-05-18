<?php

namespace Twig\Functions;

use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;
use function array_map;

class GetAllBloodTypes extends TwigFunction
{
    public static function getName(): string
    {
        return "get_all_blood_types";
    }

    public static function call(): mixed
    {
        return array_map(
            static fn(BloodType $type) => new Blood($type),
            BloodType::cases()
        );
    }
}
