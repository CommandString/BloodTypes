<?php

use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;

require_once __DIR__ . '/vendor/autoload.php';

const ITEM_PREFIX = "* ";
const H2 = "\n## ";
const H3 = "\n### ";

$forType = static function (BloodType $type): void {
    $blood = new Blood($type);
    echo H2 . "Blood Type: {$blood->getType()->value}\n"; // A+

    echo H3 . "Proteins:\n";
    foreach ($blood->getProteins() as $protein) {
        echo ITEM_PREFIX . "{$protein->value}\n";
    }

    echo H3 . "Antibodies:\n";
    foreach ($blood->getAntibodies() as $antibody) {
        echo ITEM_PREFIX . "{$antibody->value}\n";
    }

    echo H3. "Can Donate To:\n";
    foreach (BloodType::cases() as $type) {
        $toReceive = new Blood($type);

        echo $blood->canDonateTo($toReceive) ? ITEM_PREFIX . "{$toReceive->getType()->value}\n" : '';
    }

    echo H3 . "Can Receive From:\n";
    foreach (BloodType::cases() as $type) {
        $toDonate = new Blood($type);

        echo $blood->canReceiveFrom($toDonate) ? ITEM_PREFIX . "{$toDonate->getType()->value}\n" : '';
    }
};

$divider = "---\n";
foreach (BloodType::cases() as $type) {
    $forType($type);
    echo $divider;
}
