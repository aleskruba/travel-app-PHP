<?php 
    use Core\App;
    use Core\Database;
    use Html\RegistrationForm;


require_once 'Core/redirect.php';

$errorMessage = "<script>
Toastify({
    text: 'Přihlášení nebylo úspěšné',
    duration: 3000, // Duration in milliseconds
    gravity: 'top', // Display position: 'top', 'bottom', 'left', 'right'
    backgroundColor: 'linear-gradient(to right, #ff4d4d, #ff8080)' // Background color for danger
}).showToast();
</script>";

// Start the session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // Extract individual properties
    $email = $user['email'];
    $givenName = $user['givenName'];
    $familyName = $user['familyName'];
    $picture = $user['picture'];

    // Output user information
    echo '<pre>';
    echo "Email: $email\n";
    echo "Given Name: $givenName\n";
    echo "Family Name: $familyName\n";
    echo "Picture: $picture\n";
    echo '</pre>';

    // Revoke Google token
    if (isset($user->token['access_token'])) {
        $accessToken = $user->token['access_token'];
        $client->setAccessToken($accessToken);
        $client->revokeToken($accessToken);
    }

    // Unset the Google session data
    unset($_SESSION['user']);
  
    // Optionally destroy the entire session
    session_destroy();

    // Restart the session
    session_start();


    if ($email) {
        $db = App::resolve(Database::class);
      
        $user = $db->query("select * from user where googleEmail = :googleEmail",[
            'googleEmail' => $email
        ])->find();
    
    if (!$user) {
        $errors['userexists'] = 'Tento účet není zaregistrován';
        $_SESSION['errors'] = $errors;
    
        header("Location: " . getUrl('signup?registration=error'));
        exit();
    } else {
    
      
        login($user); 
        header("Location: " . getUrl('?registration=success'));
        exit;   
    }
    
    
       } else {
    
        header("Location: " . getUrl('signup?registration=error'));
    
    
    }
    
/*     $_SESSION['user'] = [
        'email' => $email,
        'givenName' => $givenName,
        'familyName' => $familyName,
        'picture' => $picture
    ];

    session_regenerate_id(true); // Regenerate session ID for security */


} else {
    echo 'Failed to retrieve user information.';
}
?>
