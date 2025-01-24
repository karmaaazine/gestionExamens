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
$routes->get('/admin/dashboard', 'adminLoginController::dashboard');
$routes->get('/logout_admin', 'adminLoginController::logout');


$routes->get('/admin/prof_view', 'gestionProfController::index');
$routes->delete('/admin/teachers/delete/(:num)', 'gestionProfController::delete/$1');

$routes->get('/admin/gestion_prof/add/', 'gestionProfController::add');
$routes->post('/admin/gestion_prof/add/', 'gestionProfController::add');

$routes->get('/admin/gestion_prof/edit/(:num)', 'gestionProfController::edit/$1');
$routes->post('/admin/gestion_prof/edit/(:num)', 'gestionProfController::edit/$1');

$routes->get('/admin/student_view', 'gestionEtudiantController::index');
$routes->delete('/admin/student_view/delete/(:num)', 'gestionEtudiantController::delete/$1');


