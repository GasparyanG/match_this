<?php

namespace App\Models\EntityOperations;

use App\Models\Entities\Employee;

class EmployeeHelper
{
    public static function prepareEmployees(array $structuredFile): array
    {
        $employees = [];

        forEach ($structuredFile as $item) {
            $employees[] = self::buildEmployee($item);
        }

        return $employees;
    }

    private static function buildEmployee(array $item): Employee
    {
        $employee = new Employee();

        $employee->setName($item[Employee::NAME]);
        $employee->setEmail($item[Employee::EMAIL]);
        $employee->setDivision($item[Employee::DIVISION]);
        $employee->setAge($item[Employee::AGE]);
        $employee->setTimezone($item[Employee::TIMEZONE]);

        return $employee;
    }
}