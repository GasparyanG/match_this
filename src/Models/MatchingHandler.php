<?php

namespace App\Models;

use App\Models\AverageMatchingEngine\AverageMatchingFactory;
use App\Models\AverageMatchingEngine\OptimalCombination;
use App\Models\EntityOperations\EmployeeHelper;
use App\Models\EntityOperations\EmployeeScore;
use Symfony\Component\HttpFoundation\Request;

class MatchingHandler
{
    public function match(Request $req): array
    {
        $fileHandler = new FileHandler();
        $structuredFile = $fileHandler->getStructuredFile();

        $employees = EmployeeHelper::prepareEmployees($structuredFile);

        foreach ($employees as $employee)
            EmployeeScore::prepareEmployeeMatches($employee, $employees);

        $averageMatchingStrategy = AverageMatchingFactory::create(OptimalCombination::STRATEGY);
        $averageMatchingStrategy->process($employees);

        // TODO: Get result and send it to controller.

        return ["test" => true];
    }
}