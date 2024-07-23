<?php
   use Core\App;
    use Core\Database;
    use Html\ChangePasswordForm;
    use Models\User;

    $db = App::resolve(Database::class);

$userModel = new User($db);

   $heading = "Update Password";
   
   
// Check if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    $form = new ChangePasswordForm();
    $isValid = $form->validateChangePassword($password, $confirmPassword);

    $currentUserID = isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : '';

    if ($isValid) {
        // Check if user exists
        $user = $userModel->finduser($currentUserID);

        if (!$user) {
            $_SESSION['pwderrors']['userexists'] = 'Tento uživatel neexistuje';
            $redirectUrl = getUrl('profile?update=error');
            header("Location: " . $redirectUrl);
            exit();
        }

        // Change password
        $userModel->changePassword($currentUserID, $password);

        // Redirect on successful update
        unset($_SESSION['pwderrors']);
        $redirectUrl = getUrl('profile?update=success');
        header("Location: " . $redirectUrl);
        exit;
    } else {
        // Handle validation errors
        $_SESSION['pwderrors'] = $form->pwderrors();
        $redirectUrl = getUrl('profile?update=error');
        header("Location: " . $redirectUrl);
        exit;
    }
}