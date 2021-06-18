<?php


namespace App\Models\AverageMatchingEngine;


class AverageMatchingFactory
{
    private static array $matchingStrategies = [
        OptimalCombination::class
    ];

    public static function create(int $type): ?AverageMatchingInterface
    {
        foreach (self::$matchingStrategies as $strategy) {
            $strategyObj = (new $strategy());
            if ($strategyObj->isUsed($type))
                return $strategyObj;
        }

        return null;
    }
}