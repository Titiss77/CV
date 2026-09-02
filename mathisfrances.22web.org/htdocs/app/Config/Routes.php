<?php

declare(strict_types=1);

use CodeIgniter\Router\RouteCollection;

// @var RouteCollection $routes
$routes->get('/', 'Home::index');
$routes->get('tableau', 'Home::tableau');
$routes->get('projets', 'Home::projets');
$routes->get('contact', 'Home::contact');
$routes->post('contact/submit', 'Home::submitContact');
$routes->get('cv', 'Home::cv');
$routes->get('veille', 'Veille::index');
$routes->get('veille/fetch_rss', 'Veille::fetch_rss');
