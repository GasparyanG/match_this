<?php

namespace App\Models;

use App\Models\EntityOperations\EmployeeHelper;
use Symfony\Component\HttpFoundation\Request;

class MatchingHandler
{
    public function match(Request $req): array
    {
        $fileHandler = new FileHandler();
        $structuredFile = $fileHandler->getStructuredFile();

        $employees = EmployeeHelper::prepareEmployees($structuredFile);

        foreach ($employees as $employee)
            file_put_contents("test", $employee->repr() . "\n\n", 8);

        return ["test" => true];
    }
}