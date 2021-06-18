<?php

namespace App\Models\AverageMatchingEngine;

use App\Models\Entities\Employee;
use App\Models\Entities\Match;

class OptimalCombination extends AbstractAverageMatching implements AverageMatchingInterface
{
    const STRATEGY = 0;

    /**
     * {@inheritDoc}
     */
    public function process(array $employees, int $index = 0): void
    {
        if (count($employees) <= $index) return;

        $employee = $employees[$index];
        if ($employee->isChosen()) {
            $this->operateOnTheNext($employees, $employee, $index + 1);
        } else {
            foreach ($employee->getScoring() as $match) {
                if ($match->firstIsChosen() || $match->lastIsChosen())
                    continue;

                $this->add($match);
                $this->operateOnTheNext($employees, $employee, $index + 1);
            }

            $this->resetEmployee($employee);
        }
    }

    private function isNext(array $employees, $index): bool
    {
        return count($employees) > $index + 1;
    }

    private function update(): void
    {
        // Update combination.
    }


    private function add(Match $match): void
    {
        $match->chooseFirst();
        $match->chooseLast();

        // Add to combination.
    }

    private function operateOnTheNext(array $employees, Employee $employee, int $index): void
    {
        if (!$this->isNext($employees, $index)) {
            $this->resetEmployee($employee);
            $this->update();
        } else
            $this->process($employees, $index + 1);
    }

    private function resetEmployee(Employee $employee): void
    {
        $employee->setChosen(false);
    }
}