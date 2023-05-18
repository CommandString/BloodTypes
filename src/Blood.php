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

    public function canReceive(self|BloodType $blood): bool
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

    public function canDonate(self|BloodType $blood): bool
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
