<?php

/**
 * @file
 * Main point and general functions that need to be loaded to run the application.
 */

use Core\Session;
use Core\Router;
use Core\Controller;
use Core\Message;

// Get dependencies handled by Composer.
require_once __DIR__ . '/../vendor/autoload.php';

// Get env vars.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Dev/debug settings.
if ($_ENV['APP_ENV'] == 'dev') {
  Kint\Renderer\RichRenderer::$folder = false;
} else {
  Kint\Kint::$enabled_mode = false;
}

// Starts a session.
$session = new Session();
$session::start();

// Starts router/front controller and get theme settings.
$router = new Router();
$settings = $router->getSettings();

// Check if user with a specific role has access to the current page.
if (!$session::hasAccessByRole($settings['access_role'])) {
  Message::set('Access restricted.', 'error');
  header('Location: /');
  exit;
}

// Get controller and specific controller data to render the view.
$controller = new Controller();
// Variable to use in theme to print the specific view.
$view = $controller->renderView($settings['view'], $router->getControllerData());

// Get the message system.
$message = Message::get();
