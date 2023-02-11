<?php

use Core\Router;
/**
 * Start router
 */
$router = new Router();


/**
 * Users Routes
 */
$router->addRoute('GET', '/api/users/', function() {
    $users = new Controllers\Api\User\Index;
    return ($users->index());
});

$router->addRoute('GET', '/api/users/{user_id}', function($params) {
    $users = new Controllers\Api\User\Get;
    return ($users->user($params['user_id']));
});

$router->addRoute('DELETE', '/api/users/{user_id}', function($params) {
    $users = new Controllers\Api\User\Delete;
    return ($users->delete($params['user_id']));
});

$router->addRoute('PUT', '/api/users/{user_id}', function($params) {
    $users = new Controllers\Api\User\Update;
    return ($users->update($params['user_id']));
});

$router->addRoute('POST', '/api/users/', function() {
    $users = new Controllers\Api\User\Create;
    return ($users->create());
});

/**
 * Addresses Routes
 */
$router->addRoute('GET', '/api/addresses/', function() {
    $address = new Controllers\Api\Address\Index;
    return ($address->index());
});

$router->addRoute('GET', '/api/addresses/{address_id}', function($params) {
    $address = new Controllers\Api\Address\Get;
    return ($address->get($params['address_id']));
});

/**
 * States Routes
 */
$router->addRoute('GET', '/api/states/', function() {
    $state = new Controllers\Api\State\Index;
    return ($state->index());
});

$router->addRoute('GET', '/api/states/{state_id}', function($params) {
    $state = new Controllers\Api\State\Get;
    return ($state->get($params['state_id']));
});

/**
 * Cities Routes
 */
$router->addRoute('GET', '/api/cities/', function() {
    $city = new Controllers\Api\City\Index;
    return ($city->index());
});

$router->addRoute('GET', '/api/cities/{city_id}', function($params) {
    $city = new Controllers\Api\City\Get;
    return ($city->get($params['city_id']));
});


/**
 * Handle the routes request
 */
$router->handleRequest();