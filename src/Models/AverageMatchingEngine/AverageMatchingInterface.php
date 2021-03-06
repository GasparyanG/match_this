<?php


namespace App\Models\AverageMatchingEngine;


use App\Models\Entities\Employee;
use App\Models\Entities\Match;

interface AverageMatchingInterface
{
    /**
     * @param int $type
     * @return bool
     */
    public function isUsed(int $type): bool;

    /**
     * @param Employee[] $employees
     * @param int $index
     */
    public function process(array $employees, int $index = 0): void;

    /**
     * @return Match[]
     */
    public function getCombination(): array;
}