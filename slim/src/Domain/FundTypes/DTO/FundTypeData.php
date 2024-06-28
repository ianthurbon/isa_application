<?php

namespace App\Domain\FundTypes\DTO;

class FundTypeData implements \JsonSerializable
{
    private ?int $id;
    private ?string $name;
    private ?float $currentPrice;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->currentPrice = $data['current_price'] ?? null;
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
     * Get the current price.
     *
     * @return ?float
     */
    public function currentPrice(): ?float
    {
        return $this->currentPrice;
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
            'current_price' => $this->currentPrice,
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
