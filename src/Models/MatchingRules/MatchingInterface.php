<?php


namespace App\Models\MatchingRules;


use App\Models\Entities\Match;

interface MatchingInterface
{
    public static function apply(Match $match): void;
}