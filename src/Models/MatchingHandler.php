<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Request;

class MatchingHandler
{
    public function match(Request $req): array
    {
        return ["test" => true];
    }
}