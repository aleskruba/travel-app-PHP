<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Models\Message;

$db = App::resolve(Database::class);

$messageModel = new Message($db);

$heading = "Create Message";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; ;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (isset($_GET['param1'])) {
    $countryParam = urldecode($_GET['param1']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];

        if (Validator::min($_POST['message'],1)) {
            $errors['message'] = ' Zpráva musí obsahovat text';
        }
    
        if (Validator::max($_POST['message'],500)) {
            $errors['message'] = ' Zpráva musí obsahovat max 400 znaků';
        }

        if (empty($errors)) {
  
            $messageModel->createMessage($_POST['message'], $currentUser, $countryParam);

    
            unset($_SESSION['errors']);
            unset($_SESSION['message']);
            unset($_SESSION['country']);
    
            $redirectUrl = getUrl('traveltips/' . urlencode($countryParam));
    
            // Perform the redirection
            header("Location: " . $redirectUrl);
            exit;

        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['message'] = trim($_POST['message']); 
            $_SESSION['country'] = urlencode($countryParam); 
            $redirectUrl = getUrl('traveltips/' . urlencode($countryParam).'?message=error');

            header("Location: " . $redirectUrl);
            exit;
        }



    }
}
}


