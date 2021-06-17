<?php

namespace App\Middlewares;

use App\Services\API\JsonAPI\Error;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Dispatching\DispatcherHelper\RoutingInformationHandler;
use App\Services\Dispatching\Dispatcher;
use FastRoute;

class RoutingMiddleware implements MiddlewareInterface
{
	/**
	 * @var MiddlewareInterface|null
	 */
	private $next = null;

	public function process(Request $request): Response
	{
		$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
            // API
            $r->addRoute(Request::METHOD_POST, "/match", ["MatchingDispatcher", "match"]);
        });

		$httpMethod = $request->getMethod();
		$uri = $request->getBaseUrl().$request->getPathInfo();
		$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

		switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
		        return new Response(json_encode($this->prepareError(Response::HTTP_NOT_FOUND)));
		    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED: {
                $allowedMethods = $routeInfo[1];

                $message = "Wrong method, try these instead: ";
                for ($i = 0; $i < count($allowedMethods); $i++) {
                    if (count($allowedMethods) - 1 != $i)
                        $message .= $allowedMethods[$i] . ",";
                    else
                        $message .= $allowedMethods[$i];
                }

                return new Response(json_encode(
                    $this->prepareError(Response::HTTP_METHOD_NOT_ALLOWED, $message)
                ));
            }
		    case FastRoute\Dispatcher::FOUND:
				// dispatcher handling preparation
		        $handler = $routeInfo[1];
		        $placeholders = $routeInfo[2];
		        $routingInformationHandler = new RoutingInformationHandler($handler, $placeholders);
		        
		        $dispatcher = new Dispatcher();
		        return $dispatcher->dispatch($request, $routingInformationHandler);
		}
	}

	public function setNext(MiddlewareInterface $middelware): void
	{
		$this->next = $middelware;
	}

	private function prepareError(int $statusCode, ?string $message = null): array
    {
        $error = new Error();
        $error->setTitle(Response::$statusTexts[$statusCode]);
        $error->setStatus($statusCode);

        if ($message)
            $error->setErrors([Error::MESSAGE => $message]);

        $error->arrayRepresentation();
        return $error->getRepresentation();
    }
}
