<?php
    
    namespace Core;

class Validator 
{

    public static function min($value,$length)
    {
        return strlen(trim($value)) < $length;
    }

    public static function max($value,$length)
    {
        return strlen(trim($value)) > $length;
    }

    public static function email($value)
    {
       return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function string($value)
    {
        return is_string($value) && trim($value) !== '';
    }


}