<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchingDispatcher
{
    public function match(Request $req): Response
    {
        return new Response("Hi there");
    }
}