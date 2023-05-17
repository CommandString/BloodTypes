<?php

namespace CommandString\Blood;

use LogicException;
use CommandString\Blood\Enums\Proteins;
use CommandString\Blood\Enums\Types;

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

    public function __construct(public readonly Types $type)
    {
        $this->proteins = Types::getProteinsForType($type);
        $this->antibodies = Types::getAntiBodiesForTypes($type);
    }

    public function hasAntibody(Proteins $protein): bool
    {
        return in_array($protein, $this->antibodies);
    }

    public function hasProtein(Proteins $protein): bool
    {
        return in_array($protein, $this->proteins);
    }

    public function canReceive(self $blood): bool
    {
        foreach ($this->antibodies as $antibody) {
            if ($blood->hasProtein($antibody)) {
                return false;
            }
        }

        return true;
    }

    public function canDonate(self $blood): bool
    {
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

    public function getType(): Types
    {
        return $this->type;
    }

    public static function fromProteins(Proteins ...$proteins): self
    {
        foreach (Types::cases() as $type) {
            if ($proteins === Types::getProteinsForType($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid proteins');
    }

    public static function fromAntibodies(Proteins ...$proteins): self
    {
        foreach (Types::cases() as $type) {
            if ($proteins === Types::getAntiBodiesForTypes($type)) {
                return new self($type);
            }
        }

        throw new LogicException('Invalid antibodies');
    }
}
