<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/log_process', 'LoginController::login');
$routes->get('/logout', 'LoginController::logout');

$routes->get('/admin', 'adminLoginController::index');
$routes->post('/login_process', 'adminLoginController::login');
