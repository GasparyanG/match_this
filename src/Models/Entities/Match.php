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

    public function firstIsChosen(): bool
    {
        return $this->pair->first->isChosen();
    }

    public function lastIsChosen(): bool
    {
        return $this->pair->last->isChosen();
    }

    public function chooseFirst(): void
    {
        $this->pair->first->setChosen(true);
    }

    public function chooseLast(): void
    {
        $this->pair->last->setChosen(true);
    }

    public function releaseFirst(): void
    {
        $this->pair->first->setChosen(false);
    }

    public function releaseLast(): void
    {
        $this->pair->last->setChosen(false);
    }

    public function bind(): void
    {
        $first = $this->pair->first;
        $last = $this->pair->last;

        $first->setConnection($last);
        $last->setConnection($first);
    }

    public function separate(): void
    {
        $first = $this->pair->first;
        $last = $this->pair->last;

        $first->setConnection(null);
        $last->setConnection(null);
    }
}