<?php

use App\Controllers\Admin_controllers\Admin_controller;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->get('peliculas', 'Admin_controllers\Movies_controller::list_movies');

$routes->get('/pelicula/(:num)', 'Admin_controllers\Movies_controller::movie_detail/$1');

$routes->get('series', 'Admin_controllers\Series_controller::list_series');

$routes->get('/serie/(:num)', 'Admin_controllers\Series_controller::serie_detail/$1');

$routes->get('login', 'User_controllers\User_controller::login');

$routes->post('/login-form', 'User_controllers\User_controller::loginValidation');

$routes->get('register', 'User_controllers\User_controller::register');

$routes->post('/register-form', 'User_controllers\User_controller::registerValidation');

$routes->get('logout', 'User_controllers\User_controller::logout');

$routes->get('acerca_de', 'Home::acerca_de');

$routes->get('quienes_somos', 'Home::quienes_somos');

$routes->get('admin', 'Admin_controllers\Admin_controller::admin');

$routes->get('admin/usuarios', 'Admin_controllers\Admin_controller::usuarios');

$routes->get('admin/usuarios', 'Admin_controllers\Admin_controller::usuarios');

$routes->get('admin/usuarios/ver/(:num)', 'Admin_controllers\Admin_controller::verUsuario/$1');

$routes->get('admin/usuarios/editar/(:num)', 'Admin_controllers\Admin_controller::editarUsuario/$1');

$routes->post('admin/usuarios/actualizar/(:num)', 'Admin_controllers\Admin_controller::actualizarUsuario/$1');

$routes->delete('admin/usuarios/eliminar/(:num)', 'Admin_controllers\Admin_controller::eliminarUsuario/$1');

$routes->post('admin/usuarios/cambiar-estado/(:num)', 'Admin_controllers\Admin_controller::cambiarEstado/$1');

$routes->get('admin/usuarios/crear', 'Admin_controllers\Admin_controller::crearUsuario');

$routes->post('admin/usuarios/guardar', 'Admin_controllers\Admin_controller::guardarUsuario');

$routes->get('peliculas/genero/(:segment)', 'Admin_controllers\Movies_controller::filtro_genero_pelicula/$1');

$routes->get('series/genero/(:segment)', 'Admin_controller\Series_controller::filtro_genero_serie/$1');

// $routes->get('(:segment)', 'Admin_controllers\Series_controller::genero/$1');
