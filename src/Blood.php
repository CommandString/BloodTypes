<?php

namespace CommandString\Blood;

use LogicException;
use CommandString\Blood\Enums\Proteins;
use CommandString\Blood\Enums\BloodTypes;

use function in_array;

class Blood
{
    /**
      * @var Proteins[]
     */
    protected array $proteins;

    /**
     * @var Proteins[]
     */
    protected array $antibodies;

    public function __construct(public readonly BloodTypes $type)
    {
        $this->proteins = BloodTypes::getProteinsForType($type);
        $this->antibodies = BloodTypes::getAntiBodiesForTypes($type);
    }

    public function hasAntibody(Proteins $protein): bool
    {
        return in_array($protein, $this->antibodies);
    }

    public function hasProtein(Proteins $protein): bool
    {
        return in_array($protein, $this->proteins);
    }

    public function canReceive(self|BloodTypes $blood): bool
    {
        if ($blood instanceof BloodTypes) {
            $blood = new self($blood);
        }

        foreach ($this->antibodies as $antibody) {
            if ($blood->hasProtein($antibody)) {
                return false;
            }
        }

        return true;
    }

    public function canDonate(self|BloodTypes $blood): bool
    {
        if ($blood instanceof BloodTypes) {
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

    public function getType(): BloodTypes
    {
        return $this->type;
    }

    public static function fromProteins(Proteins ...$proteins): self
    {
        foreach (BloodTypes::cases() as $type) {
            if ($proteins === BloodTypes::getProteinsForType($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid proteins');
    }

    public static function fromAntibodies(Proteins ...$proteins): self
    {
        foreach (BloodTypes::cases() as $type) {
            if ($proteins === BloodTypes::getAntiBodiesForTypes($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid antibodies');
    }
}
