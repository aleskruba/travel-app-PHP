<?php

namespace Html;

use Core\Validator;

class LoginForm
{
    protected $errors = [];

    public function validate($email, $password)
    {

        $errors = [];
        if (!Validator::email($email)){
            $errors['email'] = ' Emailová adresa není platná';
        } 
        if (!Validator::string($password)){
            $errors['password'] = 'Heslo není platné';
        } 
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

}