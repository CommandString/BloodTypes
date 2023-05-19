# BloodTypes
A composer package for bloodtypes (website is in the [gui](https://github.com/CommandString/BloodTypes/tree/gui/) branch)

# Installation

`composer require commandstring/blood`

# Usage

## Creating Blood

You can either create a blood object with **proteins**, **antibodies**, or **type**

```php
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;
use CommandString\Blood\Enums\Protein;

$bloodFromType       = new Blood(BloodType::A_POSITIVE);
$bloodFromProteins   = Blood::fromProteins(Protein::A, Protein::RH);
$bloodFromAntibodies = Blood::fromAntibodies(Antibody::B, Antibody::RH);
```

## Checking compatibility between blood types

```php
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\BloodType;
use CommandString\Blood\Enums\Protein;

$bloodType1 = new Blood(BloodType::A_POSITIVE);
$bloodType2 = new Blood(BloodType::O_NEGATIVE);

$bloodType1->canDonateTo($bloodType2); // false
$bloodType1->canReceiveFrom($bloodType2); // true
$bloodType2->canDonateTo($bloodType1); // true
$bloodType2->canReceiveFrom($bloodType1); // false
```

## Getting Proteins and Antibodies

```php
use CommandString\Blood\Enums\Protein;

/** 
 * @var \CommandString\Blood\Blood $bloodType1 
 * @var Protein[] $proteins
 * @var Protein[] $antibodies
 */
$proteins = $bloodType1->getProteins();
$antibodies = $bloodType1->getAntibodies();
````

## Getting Type

```php
use CommandString\Blood\Enums\BloodType;

/** 
 * @var \CommandString\Blood\Blood $bloodType1 
 * @var BloodType $type
 */
$type = $bloodType1->getType();
$type = $bloodType1->type; 
```

---

# Example Script

```php
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

```

# Output

## Blood Type: A-

### Proteins:
* A

### Antibodies:
* B
* RH

### Can Donate To:
* A-
* A+
* AB-
* AB+

### Can Receive From:
* A-
* A+
* AB-
* AB+

### Is Universal Donor: No

### Is Universal Recipient: No

---

## Blood Type: A+

### Proteins:
* A
* RH

### Antibodies:
* B

### Can Donate To:
* A+
* AB+

### Can Receive From:
* A+
* AB+

### Is Universal Donor: No

### Is Universal Recipient: No

---

## Blood Type: B-

### Proteins:
* B

### Antibodies:
* A
* RH

### Can Donate To:
* B-
* B+
* AB-
* AB+

### Can Receive From:
* B-
* B+
* AB-
* AB+

### Is Universal Donor: No

### Is Universal Recipient: No

---

## Blood Type: B+

### Proteins:
* B
* RH

### Antibodies:
* A

### Can Donate To:
* B+
* AB+

### Can Receive From:
* B+
* AB+

### Is Universal Donor: No

### Is Universal Recipient: No

---

## Blood Type: AB-

### Proteins:
* A
* B

### Antibodies:
* RH

### Can Donate To:
* AB-
* AB+

### Can Receive From:
* AB-
* AB+

### Is Universal Donor: No

### Is Universal Recipient: No

---

## Blood Type: AB+

### Proteins:
* A
* B
* RH

### Antibodies:

### Can Donate To:
* AB+

### Can Receive From:
* AB+

### Is Universal Donor: No

### Is Universal Recipient: Yes

---

## Blood Type: O-

### Proteins:

### Antibodies:
* A
* B
* RH

### Can Donate To:
* A-
* A+
* B-
* B+
* AB-
* AB+
* O-
* O+

### Can Receive From:
* A-
* A+
* B-
* B+
* AB-
* AB+
* O-
* O+

### Is Universal Donor: Yes

### Is Universal Recipient: No

---

## Blood Type: O+

### Proteins:
* RH

### Antibodies:
* A
* B

### Can Donate To:
* A+
* B+
* AB+
* O+

### Can Receive From:
* A+
* B+
* AB+
* O+

### Is Universal Donor: No

### Is Universal Recipient: No

---
