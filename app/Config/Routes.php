<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//========================== LANGUAGE ========================
$routes->get('switch-lang/(:any)', 'Language::switch/$1');

$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// ====================== DASHBOARD ======================
$routes->get('dashboard', 'Dashboard::index');

// API cho Dashboard
$routes->group('api/dashboard', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('cards', 'DashboardApi::getCards');
    $routes->get('charts', 'DashboardApi::getCharts');
});

// ====================== USERS ======================
// Web Routes (giữ để render trang)
$routes->group('users', function($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('create', 'Users::create');
    $routes->get('edit/(:num)', 'Users::edit/$1');
});

// API Routes
$routes->group('api/users',['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('store', 'UsersApi::store');
    $routes->post('update/(:num)', 'UsersApi::update/$1');
    $routes->post('delete/(:num)', 'UsersApi::delete/$1');
});

// ====================== PRODUCTS ======================
// Web Routes
$routes->group('products', function($routes) {
    $routes->get('/', 'Products::index');
    $routes->get('create', 'Products::create');
    $routes->get('edit/(:num)', 'Products::edit/$1');
});
// API Routes
$routes->group('api/products',['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('store', 'ProductsApi::store');
    $routes->post('update/(:num)', 'ProductsApi::update/$1');
    $routes->get('info/(:num)', 'ProductsApi::getInfo/$1');
    $routes->post('set-main/(:num)/(:num)', 'ProductsApi::setMainImage/$1/$2');
    $routes->post('delete-image/(:num)', 'ProductsApi::deleteImage/$1');
    $routes->post('delete/(:num)', 'ProductsApi::delete/$1');
});

// Products Info Page (sidebar + detail)
$routes->get('products-info', 'Products::getInfoList');

// Presentations
$routes->get('presentations', 'Presentations::index');

// API cho Presentations
$routes->group('api/presentations', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('data', 'PresentationsApi::getData');
});

//Production Output
$routes->get('production-output',        'ProductionOutput::index');
$routes->post('production-output/save',  'ProductionOutput::save');
$routes->get('production-output/export', 'ProductionOutput::export');

//Materials
$routes->get('materials',        'Materials::index');
$routes->post('materials/save',  'Materials::save');

//Process Flow
$routes->get('process', 'Process::index');
$routes->post('process/add-node',          'Process::addNode');
$routes->post('process/update-node/(:num)','Process::updateNode/$1');
$routes->post('process/delete-node/(:num)','Process::deleteNode/$1');
$routes->post('process/add-edge',          'Process::addEdge');
$routes->post('process/delete-edge/(:num)','Process::deleteEdge/$1');
$routes->post('process/save-position/(:num)', 'Process::savePosition/$1');

