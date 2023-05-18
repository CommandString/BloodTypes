<?php

namespace CommandString\Blood;

use LogicException;
use CommandString\Blood\Enums\Protein;
use CommandString\Blood\Enums\BloodType;

use function in_array;

class Blood
{
    /**
     * @var Protein[]
     */
    protected array $proteins;

    /**
     * @var Protein[]
     */
    protected array $antibodies;

    /**
     * @var BloodType[]
     */
    protected array $possibleDonors;

    /**
     * @var BloodType[]
     */
    protected array $possibleRecipients;

    public function __construct(public readonly BloodType $type)
    {
        $this->proteins = BloodType::getProteinsForType($type);
        $this->antibodies = BloodType::getAntiBodiesForTypes($type);
    }

    public function hasAntibody(Protein $protein): bool
    {
        return in_array($protein, $this->antibodies);
    }

    public function hasProtein(Protein $protein): bool
    {
        return in_array($protein, $this->proteins);
    }

    public function canReceiveFrom(self|BloodType $blood): bool
    {
        if ($blood instanceof BloodType) {
            $blood = new self($blood);
        }

        foreach ($this->antibodies as $antibody) {
            if ($blood->hasProtein($antibody)) {
                return false;
            }
        }

        return true;
    }

    public function canDonateTo(self|BloodType $blood): bool
    {
        if ($blood instanceof BloodType) {
            $blood = new self($blood);
        }

        foreach ($this->proteins as $protein) {
            if ($blood->hasAntibody($protein)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return BloodType[]
     */
    public function getPossibleDonors(): array
    {
        if (!isset($this->possibleDonors)) {
            $this->possibleDonors = [];
            foreach (BloodType::cases() as $type) {
                if ($this->canReceiveFrom($type)) {
                    $this->possibleDonors[] = $type;
                }
            }
        }

        return $this->possibleDonors;
    }

    /**
     * @return BloodType[]
     */
    public function getPossibleRecipients(): array
    {
        if (!isset($this->possibleRecipients)) {
            $this->possibleRecipients = [];
            foreach (BloodType::cases() as $type) {
                if ($this->canDonateTo($type)) {
                    $this->possibleRecipients[] = $type;
                }
            }
        }

        return $this->possibleRecipients;
    }

    public function getProteins(): array
    {
        return $this->proteins;
    }

    public function getAntibodies(): array
    {
        return $this->antibodies;
    }

    public function getType(): BloodType
    {
        return $this->type;
    }

    public static function fromProteins(Protein ...$proteins): self
    {
        foreach (BloodType::cases() as $type) {
            if ($proteins === BloodType::getProteinsForType($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid proteins');
    }

    public static function fromAntibodies(Protein ...$proteins): self
    {
        foreach (BloodType::cases() as $type) {
            if ($proteins === BloodType::getAntiBodiesForTypes($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid antibodies');
    }
}
