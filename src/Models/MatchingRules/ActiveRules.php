<?php


namespace App\Models\MatchingRules;


use App\Models\Entities\Match;

class ActiveRules
{
    /**
     * @var MatchingInterface[] $rules
     */
    private static array $rules = [
        Age::class,
        Division::class,
        Timezone::class
    ];

    public static function compute(Match $match): void
    {
        foreach (self::$rules as $rule)
            $rule::apply($match);
    }
}