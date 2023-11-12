<?php

namespace Core;

use Core\Utils\Arrays;
use Core\Request;
use Core\Cache;
use Symfony\Component\Yaml\Yaml;

/**
 * Implements routing and front controller.
 * 
 * Paths and theme settings are defined in the file "router.yml" on App folder.
 * 
 * Settings, methods and variables for the theme of a specific page.
 *
 *  An associative array containing:
 *   - controller: File name of the controller with the logic of the page
 *   - view: Path and/or file name of the template file or view. (.e.g pages/filename)
 *   - title: Page title for head and body.
 *   - body_classes: CSS classes for body tag.
 *   - access_role: Check what type of user has access, possible values:
 *      - guest (not authenticated)
 *      - auth (authenticated)
 *   - methods:
 *      - get: Controller action to handle the logic.
 *      - post: Controller action to handle the logic.
 *
 * $settings = [
 *   'controller' => '',
 *   'view' => '',
 *   'title' => '',
 *   'body_classes' => '',
 *   'access_role' => '',
 * ];
 * $methods = [
 *   'get' => '',
 *   'post' => '',
 * ];
 *
 * @see routes.yml
 */
class Router {

  protected $request;

  public function __construct() {
    $this->request = new Request();
  }

  private static function getRoutes(): array {
    $cache = new Cache();
    $key = 'routes';

    // Check if routes are cached.
    if ($cache->isCached($key)) {
      return $cache->get($key);
    }

    // Get file with routes.
    $routes = Yaml::parseFile(__DIR__ . '/../App/routes.yml');
    // Cache routes 1 day.
    $cache->set($routes, $key, 86400);

    return $routes;
  }

  public static function getCurrentPath(): string {
    $uri = parse_url($_SERVER['REQUEST_URI']);

    return empty($uri['path']) ? '/' : $uri['path'];
  }

  public function handlePathWithParams($routes): int|bool {
    $currentPath = self::getCurrentPath();

    foreach ($routes as $key => $route) {
      // Convert route to a regular expression
      $pattern = preg_replace('/:[^\/]+/', '([^\/]+)', $route);
      // Check if the URL matches the pattern
      if (preg_match("#^$pattern$#", $currentPath, $matches)) {
        $params = explode(':', $route);
        // Set the param in request.
        $this->request->setParam($params[1], $matches[1]);
        return $key;
      }
    }

    // Page Not Found
    return false;
  }

  private function getKeyPath(): int|bool {
    $routes = self::getRoutes();
    $currentPath = self::getCurrentPath();

    // Get all routing paths.
    $routerPaths = Arrays::arrayColumnRecursive($routes, 'path');
    // Get the key for the current path.
    $keyPath = array_search($currentPath, $routerPaths);
    if ($keyPath !== false) {
      return $keyPath;
    }

    // Let's see if it is a path with params.
    $keyPath = self::handlePathWithParams($routerPaths);
    return $keyPath;
  }

  private function parsePath(): array {
    $routes = self::getRoutes();
    $keyPath = $this->getKeyPath();

    $output = [];

    if (!isset($routes['pages'][$keyPath]['settings'])) {
      throw new \Exception('Settings not found in routes file for current path.');
    }
    if (!isset($routes['pages'][$keyPath]['methods'])) {
      throw new \Exception('Methods not found in routes file for current path.');
    }

    // If current path exists.
    if ($keyPath !== false) {
      $output['settings'] = $routes['pages'][$keyPath]['settings'];
      $output['methods'] = $routes['pages'][$keyPath]['methods'];;
    } else { // If current path does not exist, 404 error.
      http_response_code(404);
      $output['settings'] = $routes['pages.error']['404']['settings'];
      $output['methods'] = $routes['pages.error']['404']['methods'];
    }

    return $output;
  }

  public function getSettings(): array {
    $settings = self::parsePath();

    return $settings['settings'];
  }

  public function getMethods(): array {
    $methods = self::parsePath();

    return $methods['methods'];
  }

  public function getControllerData(): array {
    $settings = $this->getSettings();
    $methods = $this->getMethods();
    $httpMethod = $this->request->getMethod();

    if (!isset($settings['controller'])) {
      throw new \Exception('Controller not found.');
    }
    if (!array_key_exists($httpMethod, $methods)) {
      http_response_code(405);
      throw new \Exception("Method {$httpMethod} not allowed.");
    }

    // Create an instance of the specific controller.
    $appController = "App\Controllers\\" . $settings['controller'];
    $instanceController = new $appController();
    // Call the specific action to handle the request and output data for view.
    $action = $methods[$this->request->getMethod()];
    $data = $instanceController->$action() ?? [];
    // Add request values if exist.
    if (!empty($this->request->getBody())) {
      $data[$httpMethod] = $this->request->getBody();
    }

    return $data;
  }
}
