<?php

namespace Html;

use Core\Validator;

class ChangePasswordForm
{
    protected $pwderrors = [];

    public function validateChangePassword($password,$confirmPassword)
    {

        if  (Validator::min($password, 5)){
            $this->pwderrors['password'] = ' Heslo musí mít alespoň 5 znaků';
        } elseif (Validator::max($password, 10)){
            $this->pwderrors['password'] = ' Heslo musí mít maximálně 10 znaků';
        } elseif ($password !== $confirmPassword){
            $this->pwderrors['confirmPassword'] = ' Hesla se neshodují';
        }
        return empty($this->pwderrors);
    }

    public function pwderrors()
    {
        return $this->pwderrors;
    }

}