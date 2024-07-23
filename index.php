<?php

session_start();

require 'Core/functions.php';
require 'Core/Database.php';
require 'Core/Validator.php';
require 'Core/Response.php';
require 'Html/LoginForm.php';
require 'Html/RegistrationForm.php';
require 'Html/ChangePasswordForm.php';
require 'Html/UpdateProfileForm.php';
require 'Html/ResetPasswordForm.php';
require 'Core/router.php';
require 'vendor/autoload.php';
require 'views/context.php';
require 'Core/Middleware/Guest.php';
require 'Core/Middleware/Auth.php';

require 'Models/User.php';



$router = new \Core\Router();

require 'routes.php';


$method = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
$router->route($uri,$method);

// $baseUri = '/travel/';
