<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login/processLogin', 'Login::processLogin');
$routes->post('login/processRegistration', 'Login::processRegistration');
$routes->get('login/logout', 'Login::logout');
$routes->get('dashboard', 'Dashboard::index');
$routes->post('dashboard/createroom', 'Dashboard::createroom');
$routes->post('dashboard/joinroom', 'Dashboard::joinroom');
