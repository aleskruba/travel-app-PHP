<?php

use Core\App;
use Core\Validator;
use Core\Database;
use Models\Reply;

$db = App::resolve(Database::class);

$replyModel = new Reply($db);

$heading = "Create Reply";

$currentUser = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; ;

$countryParam = urldecode($_GET['param1']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $messageId = $_POST['messageId'];
        $message = $_POST['message'];

  
        $errorsReply = [];

        if (Validator::min($_POST['message'],1)) {
            $errorsReply['reply'] = ' Zpráva musí obsahovat text';
        }
    
        if (Validator::max($_POST['message'],500)) {
            $errorsReply['reply'] = ' Zpráva musí obsahovat max 400 znaků';
        }

        if (empty($errorsReply)) {
  
            $replyModel->createReply($message, $currentUser, $messageId);

    
            unset($_SESSION['errors']);
            unset($_SESSION['message']);
        
            $redirectUrl = getUrl('traveltips/' . urlencode($countryParam));
    
      
            header("Location: " . $redirectUrl);
            exit;

        } else {
            $_SESSION['errorsReply'] = $errors;
            $_SESSION['message'] = trim($_POST['message']); 
            $redirectUrl = getUrl('traveltips/' . urlencode($countryParam).'?message=error');
        
            header("Location: " . $redirectUrl);
            exit;
        }



    }




