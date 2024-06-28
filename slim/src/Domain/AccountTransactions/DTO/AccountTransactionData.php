<?php

namespace App\Domain\AccountTransactions\DTO;

class AccountTransactionData implements \JsonSerializable
{
    public const DEPOSIT_TRANSACTION = 'deposit';
    public const BUY_TRANSACTION = 'buy';
    public const SELL_TRANSACTION = 'sell';

    private ?int $id;
    private ?string $date;
    private ?int $user;
    private ?int $account;
    private ?int $fund;
    private ?string $transactionType;
    private ?float $units;
    private ?float $gbpTotal;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->date = $data['created_at'] ?? null;
        $this->user = $data['user'] ?? null;
        $this->account = $data['account'] ?? null;
        $this->fund = $data['fund'] ?? null;
        $this->transactionType = $data['transaction_type'] ?? null;
        $this->units = $data['units'] ?? null;
        $this->gbpTotal = $data['gbp_total'] ?? null;
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
     * Get the transaction date
     *
     * @return ?string
     */
    public function date(): ?string
    {
        return $this->date ? date('Y-m-d H:i:s', strtotime($this->date)) : null;
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
     * Get the account ID.
     *
     * @return ?int
     */
    public function account(): ?int
    {
        return $this->account;
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
     * Get the transaction type.
     *
     * @return ?string
     */
    public function transactionType(): ?string
    {
        return $this->transactionType;
    }

    /**
     * Get the units.
     *
     * @return ?float
     */
    public function units(): ?float
    {
        return $this->units;
    }

    /**
     * Get the total in GBP.
     *
     * @return ?float
     */
    public function gbpTotal(): ?float
    {
        return $this->gbpTotal;
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
            'date' => $this->date(),
            'user' => $this->user,
            'account' => $this->account,
            'fund' => $this->fund,
            'transaction_type' => $this->transactionType,
            'units' => $this->units,
            'gbp_total' => $this->gbpTotal,
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
