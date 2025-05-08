<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
//$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'authGuard']);
$routes->group('', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index'); 
    $routes->get('dashboard/get-ticket-data', 'Dashboard::getTicketData'); 
    $routes->get('dashboard/get-random-data', 'Dashboard::getRandomData'); 
});

//user
$routes->get('user', 'User::index'); // Menampilkan daftar user
$routes->get('user/create_user', 'User::create'); // Form tambah user
$routes->post('user/store', 'User::store'); // Simpan user baru
$routes->get('user/edit/(:any)', 'User::edit/$1'); // Form edit user
$routes->post('user/update/(:any)', 'User::update/$1'); // Proses update user // Simpan update user
$routes->get('user/delete/(:segment)', 'User::delete/$1');


//$routes->get('timsupport', 'Timsupport::index');
$routes->get('/timsupport', 'Timsupport::index');
$routes->get('/timsupport/get-data', 'Timsupport::getData'); // Tambahkan endpoint untuk AJAX
// Add these routes to your routes.php file
$routes->get('/timsupport/get-single/(:num)', 'Timsupport::getSingle/$1');
$routes->post('/timsupport/create', 'Timsupport::create');
$routes->post('/timsupport/update/(:num)', 'Timsupport::update/$1');
$routes->post('/timsupport/delete/(:num)', 'Timsupport::delete/$1');











