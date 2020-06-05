<?php


class ParamsVerification
{
    public static function VerifyParam($var,string $type):bool{
        $result = false;
        switch ($type){
            case "integer":
                $result = ParamsVerification::VerifyInteger($var);
                break;
            case "string":
                $result = ParamsVerification::VerifyString($var);
                break;
            case "double":
                $result = ParamsVerification::VerifyDouble($var);
                break;
            case "Json":
                $result = ParamsVerification::VerifyJson($var);
                break;
            case "DateTime":
                $result = ParamsVerification::VerifyDateTime($var);
                break;
            case "Email":
                $result = ParamsVerification::VerifyEmail($var);
                break;
            case "HumanName":
                $result = ParamsVerification::VerifyHumanName($var);
                break;
        }
        return $result;
    }
    public static function VerifyInteger($var):bool {
        return (string)((int)$var) === $var;
    }
    public static function VerifyString($var):bool{
        return is_string($var);
    }
    public static function VerifyDateTime($var):bool{
        return is_string($var) && (bool)date_create($var);
    }
    public static function VerifyEmail($var):bool{
        return filter_var($var,FILTER_VALIDATE_EMAIL);
    }
    public static function VerifyHumanName($var):bool{
        return is_string($var) && (bool)preg_match('/^[а-яёa-z]+$/iu',$var);
    }
    public static function VerifyDouble($var):bool{
        return filter_var($var,FILTER_VALIDATE_FLOAT);
    }
    public static function VerifyJson($var):bool{
        return is_string($var) && is_array(json_decode($var, true));
    }


}