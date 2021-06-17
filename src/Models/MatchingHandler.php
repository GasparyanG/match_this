<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Request;

class MatchingHandler
{
    public function match(Request $req): array
    {
        $fileHandler = new FileHandler();
        $structuredFile = $fileHandler->getStructuredFile();

        file_put_contents("test", print_r($structuredFile, true), 8);

        return ["test" => true];
    }
}