<?php
  

  if (!function_exists('dd')) {
    function dd($value){
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        die();
    }
}

function view($viewFile, $data = []) {
        extract($data);
        require_once($viewFile);
    }

function abort($code = 404){
    http_response_code($code);
    require "views/partials/$code.php";
    die();
 }

 function login($user){
    $_SESSION['user'] = [
        'id' => $user['id'],
        'firstName' => $user['firstName'],
        'username' => $user['username'],
        'email' => $user['email'],
        'image' => $user['image']
    ];

    session_regenerate_id(true);
 }

 function logout(){
    $_SESSION = [];
    session_unset(); 
    session_destroy(); 
    
    $params = session_get_cookie_params();
    setcookie('PHPSESSID','',time()-3600,$params['path'],$params['domain'],$params['secure'],$params['httponly']);

}

function logoutGoogle(){
    if (!isset($_SESSION['token'])) {
        header("Location: /travel/ ");
        exit;
    };

      
    require './redirect.php';

    $client->setAccessToken($_SESSION['token']);
    $client->revokeToken();
    unset($_SESSION['token']);

}

    
 function urlIs($value) {
        return $_SERVER["REQUEST_URI"] === $value;
    }

    function authorize($conditon,$status = Core\Response::FORRBIDDEN){
        if (!$conditon) {
            abort($status);
        }
    }
 
function getUrl($value) {
    $baseUri = '/travel/';
    return $baseUri .$value;
}    


$config = require('Core/config.php');

