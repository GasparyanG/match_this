<?php


namespace App\Services\API\JsonAPI;


class Error
{
    // Primary (a.k.a. top level) keys.
    const STATUS = "status";
    const TITLE = "title";
    const ERRORS = "errors";

    // Secondary keys.
    const MESSAGE = "message";

    /**
     * @var array $representation
     */
    private array $representation = [];

    /**
     * @var array $error
    */
    private array $errors = [];

    /**
     * @var string|null $title
     */
    private ?string $title = null;

    /**
     * @var string|null $status
     */
    private ?string $status = null;

    public function arrayRepresentation(): void
    {
        $this->topLevel();
    }

    private function topLevel(): void
    {
        $this->representation[self::STATUS] = $this->status;
        $this->representation[self::TITLE] = $this->title;
        $this->representation[self::ERRORS] = $this->errors;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getRepresentation(): array
    {
        return $this->representation;
    }

    /**
     * @param array $representation
     */
    public function setRepresentation(array $representation): void
    {
        $this->representation = $representation;
    }

}