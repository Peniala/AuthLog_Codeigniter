<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//$routes->get('/','Home::index');
// $routes->get('/', 'Auth::index');
$routes->get('/Auth','Auth::index');
$routes->get('/Connected', 'Auth::connected/0');
$routes->get('/Dashboard', 'Auth::generateChart');
$routes->get('/PersonnalStat', 'Auth::personnalStat');

$routes->setAutoRoute(true);
