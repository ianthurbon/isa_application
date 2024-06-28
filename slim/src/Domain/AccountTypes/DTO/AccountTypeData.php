<?php

namespace App\Domain\AccountTypes\DTO;

class AccountTypeData implements \JsonSerializable
{
    private ?int $id;
    private ?string $name;
    private ?int $maxAllowance;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->maxAllowance = $data['max_allowance'] ?? null;
    }

    /**
     * Get the ID.
     *
     * @return ?int
     */
    public function id(): ?int
    {
        return $this->id;
    }

    /**
     * Get the name.
     *
     * @return ?string
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Get the maximum allowance.
     *
     * @return ?int
     */
    public function maxAllowance(): ?int
    {
        return $this->maxAllowance;
    }

    /**
     * Convert object properties to an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'max_allowance' => $this->maxAllowance,
        ];
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
