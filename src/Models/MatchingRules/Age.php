<?php

namespace App\Models\MatchingRules;

use App\Models\Entities\Match;
use App\Models\Entities\Pair;

class Age implements MatchingInterface
{
    const PERCENT = 30;
    const DIFFERENCE = 5;

    public static function apply(Match $match): void
    {
        $diff =
            self::getAge($match, Pair::FIRST)
            - self::getAge($match, Pair::LAST);

        if (abs($diff) <= self::DIFFERENCE)
            $match->setPercent($match->getPercent() + self::PERCENT);
    }

    private static function getAge(Match $match, int $pos): int
    {
        switch ($pos) {
            case Pair::FIRST:
                return $match->getPair()->first->getAge();
            case Pair::LAST:
                return $match->getPair()->last->getAge();
        }
    }
}