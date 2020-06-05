<?php


class DefaultMethod extends Method implements IMethod
{

    public function Execute() : IReturnable
    {
        return new TheSuccess(null,"Successful Default API Method Call");
    }
    public static $ParamsList = array(
       "name"=>"integer"
    );
    public const CallableName = 'default';
    public const RequireVerification = true;
}