<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->get('/gallery', 'Gallery::index');
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/send', 'Contact::send');

// Customer Auth (Email + Password & Google OAuth)
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::doLogin');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::doRegister');
$routes->get('/auth/google', 'Auth::googleLogin');
$routes->get('/auth/callback', 'Auth::callback');
$routes->get('/auth/logout', 'Auth::logout');

// Products
$routes->get('/products', 'Product::index');
$routes->get('/products/(:segment)', 'Product::detail/$1');

// Cart
$routes->get('/cart', 'Cart::index');
$routes->post('/cart/add', 'Cart::add');
$routes->post('/cart/update', 'Cart::update');
$routes->get('/cart/remove/(:num)', 'Cart::remove/$1');
$routes->get('/cart/count', 'Cart::count');

// Checkout (customer auth required)
$routes->group('checkout', ['filter' => 'customer_auth'], function ($routes) {
    $routes->get('', 'Checkout::index');
    $routes->post('process', 'Checkout::process');
    $routes->get('success/(:num)', 'Checkout::success/$1');
    $routes->get('pending/(:num)', 'Checkout::pending/$1');
});

// Midtrans Notification (no CSRF)
$routes->post('/midtrans/notify', 'MidtransNotification::notify');

// Admin Auth Routes
$routes->get('/admin/login', 'Admin\Auth::login');
$routes->post('/admin/login', 'Admin\Auth::doLogin');
$routes->get('/admin/logout', 'Admin\Auth::logout');

// Admin Routes (protected)
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Profile
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');

    // Categories
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');

    // Products
    $routes->get('products', 'Admin\Products::index');
    $routes->get('products/create', 'Admin\Products::create');
    $routes->post('products/store', 'Admin\Products::store');
    $routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\Products::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\Products::delete/$1');
    $routes->post('products/delete-image/(:num)', 'Admin\Products::deleteImage/$1');

    // Services (legacy)
    $routes->get('services', 'Admin\Services::index');
    $routes->get('services/create', 'Admin\Services::create');
    $routes->post('services/store', 'Admin\Services::store');
    $routes->get('services/edit/(:num)', 'Admin\Services::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\Services::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\Services::delete/$1');

    // Gallery
    $routes->get('gallery', 'Admin\Gallery::index');
    $routes->get('gallery/create', 'Admin\Gallery::create');
    $routes->post('gallery/store', 'Admin\Gallery::store');
    $routes->get('gallery/edit/(:num)', 'Admin\Gallery::edit/$1');
    $routes->post('gallery/update/(:num)', 'Admin\Gallery::update/$1');
    $routes->get('gallery/delete/(:num)', 'Admin\Gallery::delete/$1');

    // Orders
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/detail/(:num)', 'Admin\Orders::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');

    // Customers
    $routes->get('customers', 'Admin\Customers::index');
    $routes->get('customers/detail/(:num)', 'Admin\Customers::detail/$1');

    // Users (admin)
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
});
