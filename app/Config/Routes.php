<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginUserController::index');
$routes->post('/log_process', 'LoginUserController::login');
$routes->get('/logout', 'LoginUserController::logout');

$routes->get('/admin', 'adminLoginController::index');
$routes->post('/login_process', 'adminLoginController::login');
$routes->get('/logout_admin', 'adminLoginController::logout');

