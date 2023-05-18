<?php

namespace CommandString\Blood\Enums;

enum BloodType: string
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
                Protein::B,
                Protein::RH
            ],
            self::A_POSITIVE->value => [
                Protein::B
            ],
            self::B_NEGATIVE->value => [
                Protein::A,
                Protein::RH
            ],
            self::B_POSITIVE->value => [
                Protein::A
            ],
            self::AB_NEGATIVE->value => [
                Protein::RH
            ],
            self::AB_POSITIVE->value => [],
            self::O_NEGATIVE->value => [
                Protein::A,
                Protein::B,
                Protein::RH
            ],
            self::O_POSITIVE->value => [
                Protein::A,
                Protein::B
            ],
        ][$type->value];
    }

    public static function getProteinsForType(self $type): array
    {
        return [
            self::A_NEGATIVE->value => [
                Protein::A
            ],
            self::A_POSITIVE->value => [
                Protein::A,
                Protein::RH
            ],
            self::B_NEGATIVE->value => [
                Protein::B
            ],
            self::B_POSITIVE->value => [
                Protein::B,
                Protein::RH
            ],
            self::AB_NEGATIVE->value => [
                Protein::A,
                Protein::B
            ],
            self::AB_POSITIVE->value => [
                Protein::A,
                Protein::B,
                Protein::RH
            ],
            self::O_NEGATIVE->value => [],
            self::O_POSITIVE->value => [
                Protein::RH
            ],
        ][$type->value];
    }
}
