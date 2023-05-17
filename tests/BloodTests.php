<?php

namespace Tests\CommandString\Blood;

use LogicException;
use PHPUnit\Framework\TestCase;
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\Proteins;
use CommandString\Blood\Enums\BloodType;

class BloodTests extends TestCase
{
    public function testCompatibility(): void
    {
        $aN = new Blood(BloodType::A_NEGATIVE);
        $abP = new Blood(BloodType::A_POSITIVE);
        $oP = new Blood(BloodType::O_POSITIVE);

        $this->assertTrue($oP->canDonate($abP));
        $this->assertFalse($abP->canDonate($oP->type));
        $this->assertTrue($abP->canReceive($oP->type));
        $this->assertFalse($aN->canReceive($abP->type));
    }

    public function testCreatingFromProteins(): void
    {
        $blood = Blood::fromProteins(Proteins::A, Proteins::RH);
        $this->assertEquals(BloodType::A_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(BloodType::AB_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Proteins::RH);
        $this->assertEquals(BloodType::O_POSITIVE, $blood->getType());
    }

    public function testCreatingFromAntibodies(): void
    {
        $blood = Blood::fromAntibodies(Proteins::A, Proteins::RH);
        $this->assertEquals(BloodType::B_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::A, Proteins::B, Proteins::RH);
        $this->assertEquals(BloodType::O_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Proteins::RH);
        $this->assertEquals(BloodType::AB_NEGATIVE, $blood->getType());
    }

    public function testGettingProteins(): void
    {
        $blood = new Blood(BloodType::A_POSITIVE);
        $this->assertEquals([Proteins::A, Proteins::RH], $blood->getProteins());
    }

    public function testGettingAntibodies(): void
    {
        $blood = new Blood(BloodType::A_POSITIVE);
        $this->assertEquals([Proteins::B], $blood->getAntibodies());
    }

    public function testInvalidProteinCombo(): void
    {
        $this->expectException(LogicException::class);
        Blood::fromProteins(Proteins::A, Proteins::A);
    }

    public function testInvalidAntibodyCombo(): void
    {
        $this->expectException(LogicException::class);
        Blood::fromAntibodies(Proteins::A, Proteins::A);
    }
}
