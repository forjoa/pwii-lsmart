<?php

use App\Controllers\Auth;
use App\Controllers\Dashboard;
use App\Controllers\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);

// create user
$routes->get('/register', [Auth::class, 'register']);
$routes->post('/signup', [Auth::class, 'signup']);

// sign in user
$routes->get('/login', [Auth::class, 'login']);
$routes->post('/signin', [Auth::class, 'signin']);

// logout user
$routes->get('/logout', [Auth::class, 'logout']);

// dashboard
$routes->get('/dashboard', [Dashboard::class, 'index']);
