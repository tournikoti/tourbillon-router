<?php

use Tourbillon\Request\HttpRequest;
use Tourbillon\Router\Router;

require '../vendor/autoload.php';

$httpRequest = new HttpRequest();

$router = new Router($httpRequest, include './config/routes.php');

var_dump($router->getByUrl(''));
