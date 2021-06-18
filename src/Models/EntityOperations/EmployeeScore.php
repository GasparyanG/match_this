<?php


namespace App\Models\EntityOperations;


use App\Models\Entities\Employee;
use App\Models\Entities\Match;
use App\Models\Entities\Pair;
use App\Models\MatchingRules\ActiveRules;

class EmployeeScore
{
    public static function prepareEmployeeMatches(Employee $emp, array $employees): void
    {
        foreach ($employees as $employee) {
            if ($emp === $employee)
                continue;

            $emp->addScore(self::match($emp, $employee));
        }
    }

    private static function match(Employee $a, Employee $b): Match
    {
        // Prepare dependencies.
        $match = new Match();
        $pair = new Pair($a, $b);

        // Prepare match and compute the matching score.
        $match->setPair($pair);
        ActiveRules::compute($match);

        return $match;
    }
}