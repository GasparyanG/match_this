<?php


namespace App\Models\AverageMatchingEngine;


abstract class AbstractAverageMatching
{
    const STRATEGY = null;

    public function isUsed(int $type): bool
    {
        return $type === static::STRATEGY;
    }
}