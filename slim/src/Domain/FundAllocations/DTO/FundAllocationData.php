<?php

namespace App\Domain\FundAllocations\DTO;

class FundAllocationData implements \JsonSerializable
{
    private ?int $id;
    private ?int $fund;
    private ?int $account;
    private ?float $percentageAllocation;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->fund = $data['fund'] ?? null;
        $this->account = $data['account'] ?? null;
        $this->percentageAllocation = $data['percentage_allocation'] ?? null;
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
     * Get the fund ID.
     *
     * @return ?int
     */
    public function fund(): ?int
    {
        return $this->fund;
    }

    /**
     * Get the account ID.
     *
     * @return ?int
     */
    public function account(): ?int
    {
        return $this->account;
    }

    /**
     * Get the percentage allocation.
     *
     * @return ?float
     */
    public function percentageAllocation(): ?float
    {
        return $this->percentageAllocation;
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
            'fund' => $this->fund,
            'account' => $this->account,
            'percentage_allocation' => $this->percentageAllocation,
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
