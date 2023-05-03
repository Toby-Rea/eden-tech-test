<?php
// Create a router instance
require_once(__DIR__ . '/core/Router.php');
$router = new Router($_SERVER);

// Page routes
$router->get('/', '/views/user/index.php');
$router->get('/users', '/views/user/index.php');
$router->get('/user', '/views/user/show.php');
$router->get('/edit', '/views/user/edit.php');
$router->get('/create', '/views/user/create.php');

// Api Routes
$router->get('/api/user', '/api/user.php');
$router->get('/api/users', '/api/users.php');
$router->put('/api/update', '/api/update.php');
$router->post('/api/create', '/api/create.php');
$router->delete('/api/delete', '/api/delete.php');

// Handle the incoming request
$router->handle();