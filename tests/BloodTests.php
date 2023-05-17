<?php

namespace Tests\CommandString\Blood;

use PHPUnit\Framework\TestCase;
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\Proteins;
use CommandString\Blood\Enums\Types;

class BloodTests extends TestCase
{
    public function testCompatibility(): void
    {
        $aN = new Blood(Types::A_NEGATIVE);
        $abP = new Blood(Types::A_POSITIVE);
        $oP = new Blood(Types::O_POSITIVE);

        $this->assertTrue($oP->canDonate($abP));
        $this->assertFalse($abP->canDonate($oP));
        $this->assertTrue($abP->canReceive($oP));
        $this->assertTrue($abP->canReceive($aN));
    }

    public function testCreatingFromProteins(): void
    {
        $blood = Blood::fromProteins(Proteins::A, Proteins::RH);
        $this->assertEquals(Types::A_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(Types::AB_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::RH);
        $this->assertEquals(Types::O_NEGATIVE, $blood->getType());
    }

    public function testCreatingFromAntibodies(): void
    {
        $blood = Blood::fromAntibodies(Proteins::A, Proteins::RH);
        $this->assertEquals(Types::B_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(Types::O_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::RH);
        $this->assertEquals(Types::AB_NEGATIVE, $blood->getType());
    }
}
