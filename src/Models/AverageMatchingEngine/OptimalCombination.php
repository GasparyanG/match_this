<?php

namespace App\Models\AverageMatchingEngine;

use App\Models\Entities\Employee;
use App\Models\Entities\Match;

class OptimalCombination extends AbstractAverageMatching implements AverageMatchingInterface
{
    const STRATEGY = 0;

    /**
     * @var Match[] $combination
     */
    private array $draftCombination = [];

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
        if (count($this->combination) === 0 ||
            ($this->total($this->combination) < $this->total($this->draftCombination)))
            $this->combination = $this->draftCombination;

        $this->draftCombination = [];
    }


    private function add(Match $match): void
    {
        $match->chooseFirst();
        $match->chooseLast();

        $this->draftCombination[] = $match;
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

    /**
     * @return Match[]
     */
    public function getCombination(): array
    {
        return $this->combination;
    }

    /**
     * @param Match[] $combination
     */
    public function setCombination(array $combination): void
    {
        $this->combination = $combination;
    }
}