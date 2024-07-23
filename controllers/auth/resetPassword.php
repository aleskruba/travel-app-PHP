
<?php

    use Core\App;
    use Core\Database;
    
    $db = App::resolve(Database::class);

    $token = $_GET['token'];
    if ($token === null) {
        $redirectUrl = getUrl('login');
        header("Location: " . $redirectUrl);
        exit;
    }

    $token_hash = hash("sha256", $token);

    $userWithToken = $db->query("select * from user where reset_token_hash = :reset_token_hash",[
        'reset_token_hash' => $token_hash
    ])->find();

    if ($userWithToken === false) {
        die('Token nenalezen');
    }

    if (strtotime($userWithToken["reset_token_expires_at"]) <= time()){
        die('token has expired');
    }

    

    require 'views/resetPassword.view.php';
