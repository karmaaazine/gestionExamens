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
$routes->get('/admin/Dashboard', 'DashboardAdminController::index');
$routes->get('/admin/logout', 'DashboardAdminController::logout');
$routes->get('/logout_admin', 'adminLoginController::logout');
$routes->get('/admin/prof_view', 'adminLoginController::show');

