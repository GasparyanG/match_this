<?php


namespace App\Models\AverageMatchingEngine;


use App\Models\Entities\Match;
use http\Encoding\Stream\Deflate;

abstract class AbstractAverageMatching
{
    const AVERAGE = "average";
    const DECIMALS = 2;
    const SEPARATOR = '.';

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

        $repr .= "Total: " . self::total($this->combination) . "\n\n";
        return $repr;
    }

    /**
     * @param Match[] $combination
     * @return int
     */
    protected static function total(array $combination): int
    {
        $result = 0;
        foreach ($combination as $match)
            $result += $match->getPercent();

        return $result;
    }

    /**
     * @param Match[] $combination
     * @return float
     */
    public static function average(array $combination): float
    {
        return number_format((float)(self::total($combination) / count($combination)),
            self::DECIMALS, self::SEPARATOR, '');
    }
}