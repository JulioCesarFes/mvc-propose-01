<?php class Router {

	private $route = null;
	private $lockRegistration = false;

	function __construct ($route) {
		$this->$route = $route;
	}

	function register ($route, $http_method, $controller, $method) {
		if ($this->lockRegistration) return false;

		if ($this->isCurrentRoute($route, $http_method)) {

			$this->lockRegistration = true;

			$params = $this->getRouteParams($route, $http_method);
			$this->callControllerAndMethod($controller, $method, $params);

		}

		return true;
	}

	function isCurrentRoute ($route, $method) {
		if ($_SERVER['REQUEST_METHOD'] != $method) return false;

		if (!$this->isRouteMatchURI($route, $_SERVER['REQUEST_URI'])) return false;

		return true;
	}

	function getRouteParams($route, $http_method) {
		preg_match($this->getRegexFromRoute($route), $uri, $matches, PREG_UNMATCHED_AS_NULL);

		array_shift($matches);

		return $matches;
	}

	function callControllerAndMethod ($controller, $method, $params) {
		$controller = new $controller();
		$controller->$method(...$params);
	}

	function isRouteMatchURI($route, $uri) {
		return preg_match($this->getRegexFromRoute($route), $uri, $matches, PREG_UNMATCHED_AS_NULL);
	}

	function getRegexFromRoute($route) {
		$response = "/^";

		foreach (explode('/', $route) as $slash) {
			$response .= "\/";

			if (substr($slash, 0, 1) == ":") {
				$response .= "(.*)";

			} else {
				$response .= $slash;

			}
		}

		return $response . "/g";
	}

}