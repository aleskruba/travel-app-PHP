<?php

namespace Html;


class ResetPasswordForm
{
    protected $errors = [];

    public function validateResetPassword($email)
    {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'Špatná emailová adresa';
        }

        return empty($this->errors);
    }

    public function addError($field, $message)
    {
        $this->errors[$field] = $message;
    }

    public function errors()
    {
        return $this->errors;
    }
}
