<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Models\TourMessage;

$db = App::resolve(Database::class);

$messageModel = new TourMessage($db);

$heading = "Create Tour Message";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; ;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (isset($_GET['param1'])) {


    $id = urldecode($_GET['param1']);

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];

        if (Validator::min($_POST['message'],1)) {
            $errors['message'] = ' Zpráva musí obsahovat text';
        }
    
        if (Validator::max($_POST['message'],500)) {
            $errors['message'] = ' Zpráva musí obsahovat max 400 znaků';
        }

        if (empty($errors)) {
  
            $messageModel->createTourMessage($_POST['message'], $currentUser, $id);

    
            unset($_SESSION['errors']);
            unset($_SESSION['message']);
           
    
            $redirectUrl = getUrl('spolucesty/' . urlencode($id));
    
            // Perform the redirection
            header("Location: " . $redirectUrl);
            exit;

        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['message'] = trim($_POST['message']); 
              $redirectUrl = getUrl('spolucesty/' . urlencode($id).'?message=error');

            header("Location: " . $redirectUrl);
            exit;
        }



    }
}
}


