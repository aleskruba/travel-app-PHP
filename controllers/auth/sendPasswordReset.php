<?php

use Core\App;
use Core\Database;
use Html\ResetPasswordForm;

$db = App::resolve(Database::class);

$email = $_POST['email'];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$form = new ResetPasswordForm();

$isValid = $form->validateResetPassword($email);

if ($isValid) {
    $user = $db->query("select * from user where email = :email", ['email' => $email])->find();

    if (!$user) {
        $form->addError('noemail', 'Tato emailova adresa není zaregistrovaná');
        $_SESSION['errors'] = $form->errors();
        $_SESSION['email'] = $_POST['email'];
        
        $redirectUrl = getUrl('forgottenpassword?update=error');
        header("Location: $redirectUrl");
    
        die();
    }

    if (empty($errors)) {
        $query = "UPDATE user 
        SET reset_token_hash = :reset_token_hash, reset_token_expires_at = :reset_token_expires_at
        WHERE email = :email";

        $updateUser = $db->query($query, [
            ':reset_token_hash' => $token_hash,
            ':reset_token_expires_at' => $expiry,
            ':email' => $_POST['email']
        ]);

        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("reactbrno@centrum.cz");
        $mail->addAddress($email);
        $mail->Subject = "TATO ZPRÁVA JE TESTOVACÍ -  TEST ZAPOMENUTÉHO HESLA ";
        $mail->Body = <<<END
        Klikni na odkaz <a href="http://localhost/travel/resetpassword?token=$token">zde</a> k resetování hesla
        END;

        try {
            $mail->send();
            echo "Zpráva byla odeslána:";
        } catch (\Exception $e) {
            echo "Zpráva nemohla být odeslána: {$mail->ErrorInfo}";
        }

        die();
        
        $redirectUrl = getUrl('profile?update=success');
        header("Location: $redirectUrl");
        unset($_SESSION['email']);
        exit;
    }
} else {
    $_SESSION['errors'] = $form->errors();
    $redirectUrl = getUrl('forgottenpassword?update=error');
    header("Location: $redirectUrl");
    unset($_SESSION['email']);
    die();
}


