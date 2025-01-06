<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/admin', 'adminLoginController::index');
$routes->post('/login_process', 'adminLoginController::login');
