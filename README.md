# BloodTypes
A composer package for bloodtypes

# Installation

`composer require commandstring/blood`

# Example Script

```php
<?php

use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;

require_once __DIR__ . '/vendor/autoload.php';

const ITEM_PREFIX = "* ";

$forType = static function (BloodType $type): void {
    $blood = new Blood($type);
    echo "Blood Type: {$blood->getType()->value}\n\n"; // A+

    echo "Blood Proteins:\n";
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

        echo $blood->canDonate($toReceive) ? ITEM_PREFIX . "{$toReceive->getType()->value}\n" : '';
    }

    echo "\nCan Receive From:\n";
    foreach (BloodType::cases() as $type) {
        $toDonate = new Blood($type);

        echo $blood->canReceive($toDonate) ? ITEM_PREFIX . "{$toDonate->getType()->value}\n" : '';
    }
};

$divider = "-------------------------\n";
foreach (BloodType::cases() as $type) {
    echo $divider;
    $forType($type);
}
echo $divider;
```

## Output

```
-------------------------
Blood Type: A-

Blood Proteins:
* A

Blood Antibodies:
* B
* RH

Can Donate To:
* A-
* A+
* AB-
* AB+

Can Receive From:
* A-
-------------------------
Blood Type: A+

Blood Proteins:
* A
* RH

Blood Antibodies:
* B

Can Donate To:
* A+
* AB+

Can Receive From:
* A-
* A+
* O-
* O+
-------------------------
Blood Type: B-

Blood Proteins:
* B

Blood Antibodies:
* A
* RH

Can Donate To:
* B-
* B+
* AB-
* AB+

Can Receive From:
* B-
-------------------------
Blood Type: B+

Blood Proteins:
* B
* RH

Blood Antibodies:
* A

Can Donate To:
* B+
* AB+

Can Receive From:
* B-
* B+
* O-
* O+
-------------------------
Blood Type: AB-

Blood Proteins:
* A
* B

Blood Antibodies:
* RH

Can Donate To:
* AB-
* AB+

Can Receive From:
* A-
* B-
* AB-
-------------------------
Blood Type: AB+

Blood Proteins:
* A
* B
* RH

Blood Antibodies:

Can Donate To:
* AB+

Can Receive From:
* A-
* A+
* B-
* B+
* AB-
* AB+
* O-
* O+
-------------------------
Blood Type: O-

Blood Proteins:
* RH

Blood Antibodies:
* A
* B
* RH

Can Donate To:
* A+
* B+
* AB+
* O+

Can Receive From:
-------------------------
Blood Type: O+

Blood Proteins:
* RH

Blood Antibodies:
* A
* B

Can Donate To:
* A+
* B+
* AB+
* O+

Can Receive From:
* O-
* O+
-------------------------
```