<?php

namespace App\Domain\Users\DTO;

class UserData implements \JsonSerializable
{
    private ?int $id;
    private ?string $name;
    private ?string $niNumber;
    private ?string $apiToken;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->niNumber = $data['ni_number'] ?? null;
        $this->apiToken = $data['api_token'] ?? null;
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
     * Get the NI number.
     *
     * @return ?string
     */
    public function niNumber(): ?string
    {
        return $this->niNumber;
    }

    /**
     * Get the API token.
     *
     * @return ?string
     */
    public function apiToken(): ?string
    {
        return $this->apiToken;
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
            'ni_number' => $this->niNumber,
            'api_token' => $this->apiToken,
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
