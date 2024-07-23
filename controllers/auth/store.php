<?php


use Core\App;
use Core\Database;
use Html\RegistrationForm;
use Models\User;
    
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$errorMessage = "<script>
Toastify({
    text: 'Registrace nebyla úspěšná',
    duration: 3000, // Duration in milliseconds
    gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
    backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)' // Background color for danger
}).showToast();
</script>";

$form = new RegistrationForm();
$isValid = $form->validate($email, $password,$confirmPassword); 
$db = App::resolve(Database::class);

$userModel = new User($db);


if ($isValid) {
  
    $user = $userModel->findByEmail($email);

if ($user) {
    $errors['userexists'] = 'Tento email je již zaregistrován';
    $_SESSION['errors'] = $errors;

    view('views/signup.view.php', ['errorMessage'=> $errorMessage ]);
    exit();
} else {

     $insertResult = $userModel->insert($email, $password);

}

login($user); 
header("Location: " . getUrl('?registration=success'));
exit;

} else {

    $errors = $form->errors();
    $_SESSION['errors'] = $errors;
    view('views/signup.view.php', ['errorMessage'=> $errorMessage ]);


}


