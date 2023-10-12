<?php

/**
 * @file
 * Main point and general functions that need to be loaded to run the application.
 */

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
$session = new Core\Session();
$session::start();

// Starts router/front controller and get theme settings.
$router = new Core\Router();
$settings = $router->getSettings();

// Check if user with a specific role has access to the current page.
if (!$session::hasAccessByRole($settings['access_role'])) {
  header('Location: /');
  exit;
}

// Get specific controller.
if (isset($settings['controller'])) {
  // Create an instance of the specific controller.
  $appController = "App\Controllers\\" . $settings['controller'];
  $instanceController = new $appController();
  // Call the index method to handle the request.
  $data = $instanceController->index();

  $controller = new Core\Controller();
}

// Get the message system.
$message = Core\Message::get();
