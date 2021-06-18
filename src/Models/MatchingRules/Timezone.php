<?php

namespace App\Models\MatchingRules;

use App\Models\Entities\Match;
use App\Models\Entities\Pair;

class Timezone implements MatchingInterface
{
    const PERCENT = 40;

    public static function apply(Match $match): void
    {
        if (self::getTimezone($match, Pair::FIRST) === self::getTimezone($match, Pair::LAST))
            $match->setPercent($match->getPercent() + self::PERCENT);
    }

    private static function getTimezone(Match $match, int $pos): int
    {
        switch ($pos) {
            case Pair::FIRST:
                return $match->getPair()->first->getTimezone();
            case Pair::LAST:
                return $match->getPair()->last->getTimezone();
        }
    }
}