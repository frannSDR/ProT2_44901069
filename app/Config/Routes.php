<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('peliculas', 'Home::peliculas');

$routes->get('series', 'Home::series');

$routes->get('login', 'Home::login');

$routes->get('register', 'Home::register');

$routes->get('acerca_de', 'Home::acerca_de');

$routes->get('quienes_somos', 'Home::quienes_somos');
