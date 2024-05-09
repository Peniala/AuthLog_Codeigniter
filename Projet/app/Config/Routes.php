<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//$routes->get('/','Home::index');
$routes->get('/', 'Auth::index');

# get

$routes->get('/Auth','Auth::index');
$routes->get('/Connected', 'Auth::connected/0');
$routes->get('/Dashboard', 'Auth::generateChart');
$routes->get('/PersonnalStat', 'Auth::personnalStat');

////////////////////////// connection ///////////////////////////////////

// $routes->get('/', 'UserController::index');
// $routes->get('/inscription', 'UserController::inscriptionIndex');
// $routes->get('/connexion', 'UserController::index');
// $routes->get('/accueil', 'UserController::accueil');
// $routes->get('/deconnexion', 'UserController::deconnexion');
// $routes->get('/qrconnect', 'UserController::qrConnexion');

# post 
$routes->post('/Auth','Auth::index');

////////////////////////// connection ///////////////////////////////////

// $routes->post('/connexion', 'UserController::connexion');
// $routes->post('/inscription', 'UserController::inscription');
// $routes->post('/', 'UserController::connexion');

$routes->setAutoRoute(true);
