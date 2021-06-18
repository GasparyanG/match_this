<?php

namespace App\Controllers;

use App\Models\MatchingHandler;
use App\Services\API\JsonAPI\Error;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchingDispatcher
{
    public function match(Request $req): Response
    {
        // Prepare processed csv file and return it to a client.
        $matchModel = new MatchingHandler();
        $processedFile = $matchModel->match();

        if (isset($processedFile[Error::ERRORS]))
            return new Response(json_encode($processedFile), $processedFile[Error::STATUS]);

        return new Response(json_encode($processedFile));
    }
}