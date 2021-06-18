<?php

namespace App\Models;

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

        foreach ($employees as $employee) {
            EmployeeScore::prepareEmployeeMatches($employee, $employees);

            file_put_contents("test", $employee->scoreRepr(), 8);
        }

        return ["test" => true];
    }
}