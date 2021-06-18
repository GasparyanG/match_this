<?php

namespace App\Models\MatchingRules;

use App\Models\Entities\Match;
use App\Models\Entities\Pair;

class Division implements MatchingInterface
{
    const PERCENT = 30;

    public static function apply(Match $match): void
    {
        if (self::getDivision($match, Pair::FIRST) === self::getDivision($match, Pair::LAST))
            $match->setPercent($match->getPercent() + self::PERCENT);
    }

    private static function getDivision(Match $match, int $pos): string
    {
        switch ($pos) {
            case Pair::FIRST:
                return $match->getPair()->first->getDivision();
            case Pair::LAST:
                return $match->getPair()->last->getDivision();
        }
    }
}