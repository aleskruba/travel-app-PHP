<?php
   use Core\App;
    use Core\Database;
    use Html\ChangePasswordForm;
    
    $db = App::resolve(Database::class);

    $token = $_POST['token'];
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

    $heading = "Update Password";
      
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $form = new ChangePasswordForm();

        $isValid = $form->validateChangePassword($password,$confirmPassword); 
        
   

        if ($isValid) {
        
            $user = $db->query("select * from user where id = :id",[
                'id' => $userWithToken['id']
            ])->find();
        
        if (!$user) {
            $pwderrors['userexists'] = 'Tento uživatel neexistuje';
            $_SESSION['pwderrors'] = $pwderrors;
        
            view('views/profile.view.php', ['errorMessage'=> $errorMessage ]);
            exit();
        }
        
        if (empty($pwderrors)) {
                $query = "UPDATE user 
                            SET password = :password,  
                            reset_token_hash = null,
                            reset_token_expires_at = null
                            WHERE  id = :id";

                $updatedUser=  $db->query($query, [
                    ':password' =>  password_hash($password,PASSWORD_BCRYPT), 
                    ':id' => $userWithToken['id']
                ]);
                
                unset($_SESSION['pwderrors']);

                $redirectUrl = getUrl('login?update=success');
                header("Location: " . $redirectUrl);
                exit;
        
        }

        } else {
        
            $pwderrors = $form->pwderrors();
            $_SESSION['pwderrors'] = $pwderrors;
            $redirectUrl = getUrl('login?update=error');
            header("Location: " . $redirectUrl);

            die();
            exit;
        
            }


    }