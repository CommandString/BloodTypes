<?php

use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;

require_once __DIR__ . '/vendor/autoload.php';

const ITEM_PREFIX = "* ";

$forType = static function (BloodType $type): void {
    $blood = new Blood($type);
    echo "Blood Type: {$blood->getType()->value}\n\n"; // A+

    echo "Blood Protein:\n";
    foreach ($blood->getProteins() as $protein) {
        echo ITEM_PREFIX . "{$protein->value}\n";
    }

    echo "\nBlood Antibodies:\n";
    foreach ($blood->getAntibodies() as $antibody) {
        echo ITEM_PREFIX . "{$antibody->value}\n";
    }

    echo "\nCan Donate To:\n";
    foreach (BloodType::cases() as $type) {
        $toReceive = new Blood($type);

        echo $blood->canDonateTo($toReceive) ? ITEM_PREFIX . "{$toReceive->getType()->value}\n" : '';
    }

    echo "\nCan Receive From:\n";
    foreach (BloodType::cases() as $type) {
        $toDonate = new Blood($type);

        echo $blood->canReceiveFrom($toDonate) ? ITEM_PREFIX . "{$toDonate->getType()->value}\n" : '';
    }
};

$divider = "-------------------------\n";
foreach (BloodType::cases() as $type) {
    echo $divider;
    $forType($type);
}
echo $divider;
