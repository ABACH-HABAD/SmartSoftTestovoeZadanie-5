<?php

include_once __DIR__ . "/vendor/autoload.php";

use App\Cfg\Router;

$router = new Router();
echo $router->dispatch();
