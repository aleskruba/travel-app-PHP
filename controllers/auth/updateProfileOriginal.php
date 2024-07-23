<?php
   use Core\App;
    use Core\Validator;
    use Core\Database;

    
    $db = App::resolve(Database::class);
      
    $heading = "Update Message";
 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        
        
        $currentUserID =isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : ''; 

            $user = $db->query("select * from user where id = :id",[
                'id' => $currentUserID
            ])->find();

    
            $errors = [];

            if (Validator::min($_POST['username'],2)) {
                $errors['username'] = 'username musí obsahovat alespoň 2 znaky';
                $_SESSION['username'] = $_POST['username'];
            }
        
            if (Validator::max($_POST['username'],12)) {
                $errors['username'] = 'username musí obsahovat maximálně 12 znaků';
                $_SESSION['username'] = $_POST['username'];
            }

            if (Validator::min($_POST['firstName'],2)) {
                $errors['firstName'] = 'jméno musí obsahovat alespoň 2 znaky';
                $_SESSION['firstName'] = $_POST['firstName'];
            }
        
            if (Validator::max($_POST['firstName'],12)) {
                $errors['firstName'] = 'jméno musí obsahovat maximálně 12 znaků';
                $_SESSION['firstName'] = $_POST['firstName'];
            }

            if (Validator::min($_POST['lastName'],2)) {
                $errors['lastName'] = 'příjmení musí obsahovat alespoň 2 znaky';
                $_SESSION['lastName'] = $_POST['lastName'];
            }
        
            if (Validator::max($_POST['lastName'],12)) {
                $errors['lastName'] = 'příjmení musí obsahovat maximálně 12 znaků';
                $_SESSION['lastName'] = $_POST['lastName'];
            }


            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Špatná emailová adresa';
                $_SESSION['email'] = $_POST['email'];
            }

   /*          $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Špatná emailová adresa';
                $_SESSION['email'] = $_POST['email'];
            }
             */
            $existingUser = $db->query("SELECT * FROM user WHERE email = :email AND id != :id", [
                'email' => $email,
                'id' => $currentUserID
            ])->find();
        
            if ($existingUser) {
                $errors['email'] = 'Email již používá jiný uživatel';
                $_SESSION['email'] = $_POST['email'];
            }

            if (empty($errors)) {
                $query = "UPDATE user SET username = :username, firstName = :firstName, lastName = :lastName, email = :email WHERE id = :id";

                $updatedUser=  $db->query($query, [
                    ':username' => $_POST['username'],
                    ':firstName' => $_POST['firstName'],
                    ':lastName' => $_POST['lastName'],
                    ':email' => $_POST['email'],
                    ':id' => $currentUserID
                ]);
                
                unset($_SESSION['errors']);
                unset($_SESSION['username']);
                unset($_SESSION['firstName']);
                unset($_SESSION['lastName']);
                unset($_SESSION['email']);

                    
            $redirectUrl = getUrl('profile?update=success');
            header("Location: " . $redirectUrl);
            exit;
                
            } else {

                $_SESSION['errors'] = $errors;
                $redirectUrl = getUrl('profile?update=error');
                header("Location: " . $redirectUrl);

                die();
                exit;
            }






        }