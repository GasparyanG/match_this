<?php


namespace App\Models\Entities;


class Match
{
    private int $percent = 0;
    private ?Pair $pair = null;

    /**
     * @return int
     */
    public function getPercent(): int
    {
        return $this->percent;
    }

    /**
     * @param int $percent
     */
    public function setPercent(int $percent): void
    {
        $this->percent = $percent;
    }

    /**
     * @return Pair|null
     */
    public function getPair(): ?Pair
    {
        return $this->pair;
    }

    /**
     * @param Pair|null $pair
     */
    public function setPair(?Pair $pair): void
    {
        $this->pair = $pair;
    }

    public function emailCombination(): string
    {
        return $this->pair->first->getEmail() . " | "
            . $this->pair->last->getEmail();
    }
}