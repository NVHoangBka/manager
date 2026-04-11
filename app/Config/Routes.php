<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

//Users
$routes->get('users','Users::index');
$routes->get('users/create','Users::create');
$routes->post('users/store','Users::store');
$routes->get('users/edit/(:num)','Users::edit/$1');
$routes->post('users/update/(:num)','Users::update/$1');
$routes->get('users/delete/(:num)','Users::delete/$1');

//Products
$routes->get('products','Products::index');
$routes->get('products/create','Products::create');
$routes->post('products/store','Products::store');
$routes->get('products/edit/(:num)','Products::edit/$1');
$routes->post('products/update/(:num)','Products::update/$1');
$routes->get('products/delete/(:num)','Products::delete/$1');

//Presentationss
$routes->get('presentations','Presentations::index');

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

//Products1
$routes->get('products1','Products1::index');
$routes->get('products1/create','Products1::create');
$routes->post('products1/store','Products1::store');
$routes->get('products1/edit/(:num)','Products1::edit/$1');
$routes->post('products1/update/(:num)','Products1::update/$1');
$routes->get('products1/delete/(:num)','Products1::delete/$1');