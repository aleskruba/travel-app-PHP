<?php

use Core\App;
use Core\Database;
use Html\LoginForm;
use Models\User;

$email = $_POST['email'];
$password = $_POST['password'];
//$baseUri = '/travel/';

$errorMessage = "<script>
Toastify({
    text: 'Přihlášní nebylo úspěšné',
    duration: 3000, // Duration in milliseconds
    gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
    backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)' // Background color for danger
}).showToast();
</script>";

$db = App::resolve(Database::class);

$form = new LoginForm();
$isValid = $form->validate($email, $password); 
$userModel = new User($db);

if (!$isValid) {
    $errors = $form->errors();
    $_SESSION['errors'] = $errors;
    view('views/login.view.php', ['errorMessage' => $errorMessage]);
    die();
} else {
    
    $user = $userModel->findByEmail($email);

   if (!$user) {

    $errors['emailnotexists'] = 'Špatné heslo nebo tento email není zaregistrován';
        $_SESSION['errors'] = $errors;
        view('views/login.view.php', ['errorMessage'=> $errorMessage ]);
        die();
    } 
    
    if ($user) { 
  
        if (password_verify($password, $user['password'])) {
        login($user); 
     
        header("Location: " . getUrl('?login=success'));
        exit();
        
        } else {

        $errors['emailnotexists'] = 'Špatné heslo nebo tento email není zaregistrován';
        $_SESSION['errors'] = $errors;
      
         view('views/login.view.php', ['errorMessage'=> $errorMessage ]);
        die();
     }   


}

}

