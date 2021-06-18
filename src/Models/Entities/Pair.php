<?php


namespace App\Models\Entities;


class Pair
{
    const FIRST = 0;
    const LAST = 1;

    public Employee $first;
    public Employee $last;

    public function __construct(Employee $first, Employee $last)
    {
        $this->first = $first;
        $this->last = $last;
    }
}