<?php

namespace Tests\CommandString\Blood;

use PHPUnit\Framework\TestCase;
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\Proteins;
use CommandString\Blood\Enums\BloodTypes;

class BloodTests extends TestCase
{
    public function testCompatibility(): void
    {
        $aN = new Blood(BloodTypes::A_NEGATIVE);
        $abP = new Blood(BloodTypes::A_POSITIVE);
        $oP = new Blood(BloodTypes::O_POSITIVE);

        $this->assertTrue($oP->canDonate($abP));
        $this->assertFalse($abP->canDonate($oP));
        $this->assertTrue($abP->canReceive($oP));
        $this->assertTrue($abP->canReceive($aN));
    }

    public function testCreatingFromProteins(): void
    {
        $blood = Blood::fromProteins(Proteins::A, Proteins::RH);
        $this->assertEquals(BloodTypes::A_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(BloodTypes::AB_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::RH);
        $this->assertEquals(BloodTypes::O_NEGATIVE, $blood->getType());
    }

    public function testCreatingFromAntibodies(): void
    {
        $blood = Blood::fromAntibodies(Proteins::A, Proteins::RH);
        $this->assertEquals(BloodTypes::B_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(BloodTypes::O_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::RH);
        $this->assertEquals(BloodTypes::AB_NEGATIVE, $blood->getType());
    }

    public function testGetProteins(): void
    {
        $blood = new Blood(BloodTypes::A_POSITIVE);
        $this->assertEquals([Proteins::A, Proteins::RH], $blood->getProteins());
    }
}
