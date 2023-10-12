<?php

namespace Core;

use Core\Utils;
use Symfony\Component\Yaml\Yaml;

/**
 * Implements routing and front controller.
 * 
 * Paths and theme settings are defined in the file "router.yml" on root level.
 * 
 * Settings/variables for the theme of a specific page.
 *
 *  An associative array containing:
 *   - controller: File name of the controller with the logic of the page
 *   - view: Path and/or file name of the template file or view. (.e.g pages/filename)
 *   - title: Page title for head and body.
 *   - body_classes: CSS classes for body tag.
 *   - access_role: Check what type of user has access, possible values:
 *      - guest (not authenticated)
 *      - auth (authenticated)
 *
 * $settings = array(
 *   'controller' => '',
 *   'view' => '',
 *   'title' => '',
 *   'body_classes' => '',
 *   'access_role' => '',
 * );
 *
 * @see routes.yml
 */
class Router {

  public function getRoutes(): array {
    ob_start();

    $routes = Yaml::parseFile(__DIR__ . '/../App/routes.yml');

    return $routes;
  }

  public function getCurrentPath(): string {
    $request = parse_url($_SERVER['REQUEST_URI']);

    return empty($request['path']) ? '/' : $request['path'];
  }

  public function getSettings(): array {
    $routes = $this->getRoutes();
    $currentPath = $this->getCurrentPath();

    // Get all routing paths.
    $routerPaths = Utils::arrayColumnRecursive($routes, 'path');
    // Get the key for the current path.
    $keyPath = array_search($currentPath, $routerPaths);

    // If current path exists.
    if ($keyPath !== false) {
      $settings = $routes['pages'][$keyPath]['settings'];
    } else { // If current path does not exist, 404 error.
      http_response_code(404);
      $settings = $routes['pages.error']['404']['settings'];
    }

    return $settings;
  }
}
