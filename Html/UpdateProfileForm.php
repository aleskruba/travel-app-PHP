<?php

namespace Html;

use Core\Validator;

class UpdateProfileForm
{
    protected $errors = [];

    public function validateUpdateProfile($username, $firstName, $lastName, $email)
    {
        if (Validator::min($username, 2)) {
            $this->errors['username'] = 'username musí obsahovat alespoň 2 znaky';
        }

        if (Validator::max($username, 12)) {
            $this->errors['username'] = 'username musí obsahovat maximálně 12 znaků';
        }

        if (Validator::min($firstName, 2)) {
            $this->errors['firstName'] = 'jméno musí obsahovat alespoň 2 znaky';
        }

        if (Validator::max($firstName, 12)) {
            $this->errors['firstName'] = 'jméno musí obsahovat maximálně 12 znaků';
        }

        if (Validator::min($lastName, 2)) {
            $this->errors['lastName'] = 'příjmení musí obsahovat alespoň 2 znaky';
        }

        if (Validator::max($lastName, 12)) {
            $this->errors['lastName'] = 'příjmení musí obsahovat maximálně 12 znaků';
        }

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Špatná emailová adresa';
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}
