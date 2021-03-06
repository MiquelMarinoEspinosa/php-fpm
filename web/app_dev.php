<?php
require __DIR__ . '/../vendor/autoload.php';

use Php\Fpm\AppKernel;
use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);