<?php

namespace CommandString\Blood\Enums;

enum BloodTypes: string
{
    case A_NEGATIVE = 'A-';
    case A_POSITIVE = 'A+';
    case B_NEGATIVE = 'B-';
    case B_POSITIVE = 'B+';
    case AB_NEGATIVE = 'AB-';
    case AB_POSITIVE = 'AB+';
    case O_NEGATIVE = 'O-';
    case O_POSITIVE = 'O+';

    public static function getAntiBodiesForTypes(self $type): array
    {
        return [
            self::A_NEGATIVE->value => [
                Proteins::B,
                Proteins::RH,
            ],
            self::A_POSITIVE->value => [
                Proteins::B,
            ],
            self::B_NEGATIVE->value => [
                Proteins::A,
                Proteins::RH,
            ],
            self::B_POSITIVE->value => [
                Proteins::A,
            ],
            self::AB_NEGATIVE->value => [
                Proteins::RH,
            ],
            self::AB_POSITIVE->value => [],
            self::O_NEGATIVE->value => [
                Proteins::A,
                Proteins::B,
                Proteins::RH,
            ],
            self::O_POSITIVE->value => [
                Proteins::A,
                Proteins::B,
            ],
        ][$type->value];
    }

    public static function getProteinsForType(self $type): array
    {
        return [
            self::A_NEGATIVE->value => [
                Proteins::A,
            ],
            self::A_POSITIVE->value => [
                Proteins::A,
                Proteins::RH,
            ],
            self::B_NEGATIVE->value => [
                Proteins::B,
            ],
            self::B_POSITIVE->value => [
                Proteins::B,
                Proteins::RH,
            ],
            self::AB_NEGATIVE->value => [
                Proteins::A,
                Proteins::B,
            ],
            self::AB_POSITIVE->value => [
                Proteins::A,
                Proteins::B,
                Proteins::RH,
            ],
            self::O_NEGATIVE->value => [
                Proteins::RH,
            ],
            self::O_POSITIVE->value => [
                Proteins::RH,
            ],
        ][$type->value];
    }
}
