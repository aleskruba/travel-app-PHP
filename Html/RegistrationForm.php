<?php

namespace Html;

use Core\Validator;

class RegistrationForm
{
    protected $errors = [];

    public function validate($email, $password,$confirmPassword)
    {

        if (!Validator::email($email)){
            $this->errors['email'] = ' Emailová adresa není platná';
        } elseif (Validator::min($password, 5)){
            $this->errors['password'] = ' Heslo musí mít alespoň 5 znaků';
        } elseif (Validator::max($password, 10)){
            $this->errors['password'] = ' Heslo musí mít maximálně 10 znaků';
        } elseif ($password !== $confirmPassword){
            $this->errors['confirmPassword'] = ' Hesla se neshodují';
        }
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

}