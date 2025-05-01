<?php

// Include Composer's autoloader
require 'vendor/autoload.php';

// Use OpenAPI class from Swagger-PHP
use OpenApi\Generator;

// Specify the path to your controllers
$openapi = Generator::scan('/backend/controllers'); 

// Manually add the OpenAPI version (if missing)
$openapi->openapi = '3.0.0'; 

// Output the generated OpenAPI JSON
header('Content-Type: application/json');
echo $openapi->toJson();
