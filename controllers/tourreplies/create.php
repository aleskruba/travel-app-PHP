<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Models\TourReply;

$db = App::resolve(Database::class);

$TourReplyModel = new TourReply($db);

$heading = "Create Tour Reply";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; ;

$id = urldecode($_GET['param1']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $tourmessage_id = $_POST['tourmessage_id'];
        $message = $_POST['message'];

  
        $errorsReply = [];

        if (Validator::min($_POST['message'],1)) {
            $errorsReply['reply'] = ' Zpráva musí obsahovat text';
        }
    
        if (Validator::max($_POST['message'],500)) {
            $errorsReply['reply'] = ' Zpráva musí obsahovat max 400 znaků';
        }

        if (empty($errorsReply)) {
  
            $TourReplyModel->createTourReply($message, $currentUser, $tourmessage_id);

    
            unset($_SESSION['errors']);
            unset($_SESSION['message']);
        
            $redirectUrl = getUrl('spolucesty/' . urlencode($id));
    
      
            header("Location: " . $redirectUrl);
            exit;

        } else {
            $_SESSION['errorsReply'] = $errors;
            $_SESSION['message'] = trim($_POST['message']); 
            $redirectUrl = getUrl('traveltips/' . urlencode($id).'?message=error');
        
            header("Location: " . $redirectUrl);
            exit;
        }



    }




