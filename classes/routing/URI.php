<?php



use Slim\Interfaces\RouteCollectorInterface;

class URI
{
    private RouteCollectorInterface $routeCollector;
    public function __construct(RouteCollectorInterface $routeCollector)
    {
        $this->setRouteCollector($routeCollector);
    }

    public function getURI(string $name = null): string
    {
        if (is_null($name)) {
            return (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        }
        return (empty($_SERVER['HTTPS']) ? 'http' : 'https'). "://$_SERVER[HTTP_HOST]" . $this->routeCollector->getNamedRoute($name)->getPattern();
    }

    /**
     * @param RouteCollectorInterface $routeCollector
     */
    private function setRouteCollector(RouteCollectorInterface $routeCollector): void
    {
        $this->routeCollector = $routeCollector;
    }
}