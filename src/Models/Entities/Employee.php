<?php

namespace App\Models\Entities;

class Employee
{
    // Field Keys
    const NAME = "name";
    const EMAIL = "email";
    const DIVISION = "division";
    const AGE = "age";
    const TIMEZONE = "timezone";

    private bool $chosen = false;

    /**
     * @var Match[] $scoring
    */
    private array $scoring = [];

    private ?Employee $connection = null;

    // Fields
    private string $name;
    private string $email;
    private string $division;
    private int $age;
    private int $timezone;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDivision(): string
    {
        return $this->division;
    }

    /**
     * @param string $division
     */
    public function setDivision(string $division): void
    {
        $this->division = $division;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getTimezone(): int
    {
        return $this->timezone;
    }

    /**
     * @param int $timezone
     */
    public function setTimezone(int $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * @return bool
     */
    public function isChosen(): bool
    {
        return $this->chosen;
    }

    /**
     * @param bool $chosen
     */
    public function setChosen(bool $chosen): void
    {
        $this->chosen = $chosen;
    }

    /**
     * @return Match[]
     */
    public function getScoring(): array
    {
        return $this->scoring;
    }

    /**
     * @param Match[] $scoring
     */
    public function setScoring(array $scoring): void
    {
        $this->scoring = $scoring;
    }


    public function addScore(Match $match): void
    {
        $this->scoring[] = $match;
    }

    /**
     * @return Employee|null
     */
    public function getConnection(): ?Employee
    {
        return $this->connection;
    }

    /**
     * @param Employee|null $connection
     */
    public function setConnection(?Employee $connection): void
    {
        $this->connection = $connection;
    }

    public function repr(): string
    {
        return
            "name: " . $this->name . "\n"
            . "email: " . $this->email . "\n"
            . "division: " . $this->division . "\n"
            . "age: " . $this->age . "\n"
            . "timezone: " . $this->timezone . "\n";
    }

    public function scoreRepr(): string
    {
        $repr = "";
        foreach ($this->scoring as $score) {
            $repr .= $score->emailCombination() . ": " . $score->getPercent() . "\n";
        }

        return $repr;
    }
}