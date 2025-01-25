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

$routes->get('/admin/student/add/', 'gestionEtudiantController::add');
$routes->post('/admin/student/add/', 'gestionEtudiantController::add');

$routes->get('/admin/student/edit/(:num)', 'gestionEtudiantController::edit/$1');
$routes->post('/admin/student/edit/(:num)', 'gestionEtudiantController::edit/$1');

//$routes->get('/admin/classes_view', 'gestionClassesController::index');

//$routes->match(['get', 'post'], '/admin/classes/edit/(:num)', 'gestionClassesController::edit/$1'); // Route to edit a class by ID
/*$routes->get('/admin/classes_view', 'gestionClassesController::index');
$routes->get('/admin/classes/edit/(:num)', 'gestionClassesController::edit/$1');
$routes->post('/admin/classes/edit/(:num)', 'gestionClassesController::edit/$1');
$routes->get('/admin/classes/delete/(:num)', 'gestionClassesController::delete/$1');
$routes->post('/admin/classes/add/', 'gestionClassesController::add');*/
$routes->get('/admin/classes_view', 'gestionClassesController::index');
$routes->get('/admin/classes/edit/(:num)', 'gestionClassesController::edit/$1');
$routes->post('/admin/classes/edit/(:num)', 'gestionClassesController::edit/$1');
$routes->get('/admin/classes/delete/(:num)', 'gestionClassesController::delete/$1');
$routes->post('/admin/classes/add', 'gestionClassesController::add');
// ... other routes ...

