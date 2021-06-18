<?php


namespace App\Models\AverageMatchingEngine;


use App\Models\Entities\Match;

abstract class AbstractAverageMatching
{
    const STRATEGY = null;

    /**
     * @var Match[] $combination
     */
    protected array $combination = [];

    public function isUsed(int $type): bool
    {
        return $type === static::STRATEGY;
    }

    public function reprTheCombination(): string
    {
        $repr = "";
        foreach ($this->combination as $match)
            $repr .= $match->emailCombination() . ": " . $match->getPercent() . "\n";

        $repr .= "Total: " . $this->total($this->combination) . "\n\n";
        return $repr;
    }

    /**
     * @param Match[] $combination
     * @return int
     */
    protected function total(array $combination): int
    {
        $result = 0;
        foreach ($combination as $match)
            $result += $match->getPercent();

        return $result;
    }
}