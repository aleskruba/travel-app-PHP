<?php

use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);

//$baseUri = '/travel/';

$heading = "Edit Message";

$currentUser=isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

$countryParam = urldecode($_GET['param1']);

if (isset($_GET['id'])) {


    $query = "SELECT * from  message where id = :id ";
        
   $message =  $db->query($query, [
       ':id' => $_GET['id']
    ])->findOrFail();

    authorize($message['user_id']=== $currentUser);
}



require "views/traveltips/editMessage.php";


