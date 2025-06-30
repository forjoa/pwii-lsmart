<?php
use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Profile;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// create user
$routes->get('/sign-up', [Auth::class, 'register']);
$routes->post('/sign-up', [Auth::class, 'signup']);

// sign in user
$routes->get('/sign-in', [Auth::class, 'login']);
$routes->post('/sign-in', [Auth::class, 'signin']);

// logout user
$routes->get('/logout', [Auth::class, 'logout']);

// dashboard
$routes->get('/', [Dashboard::class, 'index']);
$routes->get('/chat/(:num)', [Dashboard::class, 'chat']);

$routes->post('/send-message', [Dashboard::class, 'sendMessage']);

$routes->delete('/history/(:num)', [Dashboard::class, 'delete']);

//profile
$routes->get('/profile', [Profile::class, 'index']);
$routes->post('/profile', [Profile::class, 'update']);
$routes->delete('/profile', [Profile::class, 'delete']);