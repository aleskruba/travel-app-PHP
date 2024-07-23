<?php
    
namespace Core;

class Authenticator


{
    public function registerAttempt($email, $password, $confirmPassword)
    {
        $db = App::resolve(Database::class);

        $user = $db->query("select * from user where email = :email",[
            'email' => $email
        ])->find();


    }

    public function loginattempt($email, $password)
    {
        $db = App::resolve(Database::class);

        $user = $db->query("select * from user where email = :email",[
            'email' => $email
        ])->find();


        
    }



}