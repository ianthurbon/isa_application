<?php

namespace App\Domain\Accounts\DTO;

class AccountData implements \JsonSerializable
{
    private ?int $id;
    private ?int $user;
    private ?string $userName;
    private ?int $type;
    private ?string $accountTypeName;
    private ?int $maxAllowance;
    private ?array $fundAllocations;
    private ?array $transactions;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->userName = $data['user_name'] ?? null;
        $this->type = $data['type'] ?? null;
        $this->accountTypeName = $data['account_type_name'] ?? null;
        $this->maxAllowance = $data['max_allowance'] ?? null;
        $this->fundAllocations = $data['fund_allocations'] ?? null;
        $this->transactions = $data['transactions'] ?? null;
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
     * Get the user ID.
     *
     * @return ?int
     */
    public function user(): ?int
    {
        return $this->user;
    }

    /**
     * Get the username.
     *
     * @return ?string
     */
    public function userName(): ?string
    {
        return $this->userName;
    }

    /**
     * Get the account type.
     *
     * @return ?int
     */
    public function type(): ?int
    {
        return $this->type;
    }

    /**
     * Get the account type name.
     *
     * @return ?string
     */
    public function accountTypeName(): ?string
    {
        return $this->accountTypeName;
    }

    /**
     * Get the maximumn account type allowance.
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
            'user' => $this->user,
            'user_name' => $this->userName,
            'type' => $this->type,
            'account_type_name' => $this->accountTypeName,
            'max_allowance' => $this->maxAllowance,
            'fund_allocations' => $this->fundAllocations,
            'transactions' => $this->transactions
        ];
    }

    /**
     * Return the fund allocations for the account
     *
     * @return ?array
     */
    public function fundAllocations(): ?array
    {
        return $this->fundAllocations;
    }

    /**
     * Return the transactions for the account
     *
     * @return ?array
     */
    public function transactions(): ?array
    {
        return $this->transactions;
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
