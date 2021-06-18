<?php

namespace App\Models;

use App\Models\AverageMatchingEngine\AbstractAverageMatching;
use App\Models\AverageMatchingEngine\AverageMatchingFactory;
use App\Models\AverageMatchingEngine\OptimalCombination;
use App\Models\Entities\Employee;
use App\Models\Entities\Match;
use App\Models\EntityOperations\EmployeeHelper;
use App\Models\EntityOperations\EmployeeScore;
use App\Services\API\JsonAPI\Resource;

class MatchingHandler
{
    public function match(): array
    {
        // Prepare desired structure from provided format.
        $fileHandler = new FileHandler();
        $structuredFile = $fileHandler->getStructuredFile();
        if (!$fileHandler->isValid())
            return $structuredFile;

        // Prepare employees with scoring.
        $employees = EmployeeHelper::prepareEmployees($structuredFile);
        foreach ($employees as $employee)
            EmployeeScore::prepareEmployeeMatches($employee, $employees);

        // Process scoring and find average matching score.
        $averageMatchingStrategy = AverageMatchingFactory::create(OptimalCombination::STRATEGY);
        $averageMatchingStrategy->process($employees);

        return $this->matching($averageMatchingStrategy->getCombination());
    }

    /**
     * @param Match[] $combination
     * @return array
     */
    private function matching(array $combination): array
    {
        $result = [];

        foreach ($combination as $match)
            $result[Resource::DATA][] = $this->matchResource($match);

        $result[Resource::META][AbstractAverageMatching::AVERAGE] = AbstractAverageMatching::average($combination);


        return $result;
    }

    private function matchResource(Match $match): array
    {
        // Populate attributes.
        $attributes = [];
        $attributes[Employee::EMAIL] = $match->emailCombination();
        $attributes[Match::PERCENT] = $match->getPercent();

        // Prepare resource.
        $resource = new Resource();
        $resource->setAttributes($attributes);
        $resource->arrayRepresentation();

        return $resource->getRepresentation();
    }
}