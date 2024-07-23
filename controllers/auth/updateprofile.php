<?php


// index.php (or your controller file)

require_once './constants/constants.php';
use Core\App;
use Core\Database;
use Models\User;
use Html\UpdateProfileForm; // Adjust this namespace as per your file structure

// Resolve database and instantiate User model
$db = App::resolve(Database::class);
$userModel = new User($db);

$form = new UpdateProfileForm(); // Instantiate your form handler if needed

// Check if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];

    $currentUserID = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

    $existingGoogleUser = $db->query("SELECT googleEmail  FROM user WHERE  id = :id", [
        'id' => $currentUserID
       ])->find();
    
   if ($existingGoogleUser['googleEmail'] !== null && $email !== $existingGoogleUser['googleEmail']  ) {

           $errors['email'] = 'Uživatelé přihlášení s Google nemhou měnit email';
             $_SESSION['errors'] = $errors;

           $redirectUrl = getUrl('profile?update=error');
           header("Location: " . $redirectUrl);
       }

    // Call updateProfile method in User model
    $updateResult = $userModel->updateProfile($currentUserID, $username, $firstName, $lastName, $email);

    if ($updateResult) {
        // Redirect on successful update
        $redirectUrl = getUrl('profile?update=success');
        header("Location: " . $redirectUrl);
        exit;
    } else {
        // Handle errors
        $_SESSION['errors'] = $_SESSION['errors'] ?? $form->errors(); // Assign form errors if any
        $_SESSION['username'] = $username;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['email'] = $email;

        $redirectUrl = getUrl('profile?update=error');
        header("Location: " . $redirectUrl);
        exit;
    }
}

// If not POST request, redirect or handle as needed
