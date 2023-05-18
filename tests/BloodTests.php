<?php

namespace Tests\CommandString\Blood;

use LogicException;
use PHPUnit\Framework\TestCase;
use CommandString\Blood\Blood;
use CommandString\Blood\Enums\Protein;
use CommandString\Blood\Enums\BloodType;

class BloodTests extends TestCase
{
    public function testCompatibility(): void
    {
        $aN = new Blood(BloodType::A_NEGATIVE);
        $abP = new Blood(BloodType::A_POSITIVE);
        $oP = new Blood(BloodType::O_POSITIVE);

        $this->assertTrue($oP->canDonateTo($abP));
        $this->assertFalse($abP->canDonateTo($oP->type));
        $this->assertTrue($abP->canReceiveFrom($oP->type));
        $this->assertFalse($aN->canReceiveFrom($abP->type));
    }

    public function testCreatingFromProteins(): void
    {
        $blood = Blood::fromProteins(Protein::A, Protein::RH);
        $this->assertEquals(BloodType::A_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Protein::A, Protein::B, Protein::RH);
        $this->assertEquals(BloodType::AB_POSITIVE, $blood->getType());

        $blood = Blood::fromProteins(Protein::RH);
        $this->assertEquals(BloodType::O_POSITIVE, $blood->getType());
    }

    public function testCreatingFromAntibodies(): void
    {
        $blood = Blood::fromAntibodies(Protein::A, Protein::RH);
        $this->assertEquals(BloodType::B_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Protein::A, Protein::B, Protein::RH);
        $this->assertEquals(BloodType::O_NEGATIVE, $blood->getType());

        $blood = Blood::fromAntibodies(Protein::RH);
        $this->assertEquals(BloodType::AB_NEGATIVE, $blood->getType());
    }

    public function testGettingProteins(): void
    {
        $blood = new Blood(BloodType::A_POSITIVE);
        $this->assertEquals([Protein::A, Protein::RH], $blood->getProteins());
    }

    public function testGettingAntibodies(): void
    {
        $blood = new Blood(BloodType::A_POSITIVE);
        $this->assertEquals([Protein::B], $blood->getAntibodies());
    }

    public function testInvalidProteinCombo(): void
    {
        $this->expectException(LogicException::class);
        Blood::fromProteins(Protein::A, Protein::A);
    }

    public function testInvalidAntibodyCombo(): void
    {
        $this->expectException(LogicException::class);
        Blood::fromAntibodies(Protein::A, Protein::A);
    }

    public function testPossibleRecipients(): void
    {
        $blood = new Blood(BloodType::A_POSITIVE);
        $this->assertEquals(
            [
                BloodType::A_POSITIVE,
                BloodType::AB_POSITIVE,
            ],
            $blood->getPossibleRecipients()
        );

        $blood = new Blood(BloodType::O_NEGATIVE);
        $this->assertEquals(
            BloodType::cases(),
            $blood->getPossibleRecipients()
        );
    }

    public function testPossibleDonors(): void
    {
        $blood = new Blood(BloodType::O_NEGATIVE);
        $this->assertEquals(
            [
                BloodType::O_NEGATIVE,
            ],
            $blood->getPossibleDonors()
        );

        $blood = new Blood(BloodType::AB_POSITIVE);
        $this->assertEquals(
            BloodType::cases(),
            $blood->getPossibleDonors()
        );
    }
}
