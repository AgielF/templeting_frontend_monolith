<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attemptLogin');
$routes->get('logout', 'AuthController::logout');
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'DashboardController::index');
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('profile', 'DashboardController::profile');
    $routes->post('profile/update', 'DashboardController::updateProfile');
    $routes->get('example', 'ExampleController::index');
    $routes->post('example/store', 'ExampleController::store');
    $routes->post('example/update/(:num)', 'ExampleController::update/$1');
    $routes->get('example/delete/(:num)', 'ExampleController::delete/$1');
    $routes->group('berita', function ($routes) {
        $routes->get('/', 'BeritaController::index');
        $routes->get('create', 'BeritaController::create');
        $routes->post('store', 'BeritaController::store');
        $routes->get('edit/(:num)', 'BeritaController::edit/$1');
        $routes->post('update/(:num)', 'BeritaController::update/$1');
        $routes->get('delete/(:num)', 'BeritaController::delete/$1');
    });
});
