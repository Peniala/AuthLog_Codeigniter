<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//$routes->get('/','Home::index');
$routes->get('/', 'Auth::index');
$routes->get('/Connected', 'Auth::connected/0');
$routes->get('/Auth','Auth::index');

// $routes->get('/', 'Inscription::search');
// $routes->post('/', 'Inscription::search');
// $routes->get('/Peniala', 'Peniala::displayCV');
// $routes->get('/Peniala/mycv', 'Peniala::displayCV');
// $routes->get('/Peniala/welcome', 'Peniala::index');
// $routes->get('/login','Login::index');
// $routes->get('/inscription','Inscription::index');
// $routes->get('/listeinscrits','Inscription::inscrire');
$routes->setAutoRoute(true);
