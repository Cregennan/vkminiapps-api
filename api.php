<?php
/**
 * @author RadioNurshat
 * @version 2.0.0
 * Entry point of RNAPI, VKTaxi edition
 *
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_ALL);
include 'engine/lib.php';
include 'engine/config.php';

$DATA = $_GET;
if (SIGN_VERIFICATION_REQUIRED){
    $IsVerified = SignVerification($DATA);
    if (!$IsVerified){
       new APIResponse(new TheError(101));
    }
}
//Including API Methods
foreach (glob("./methods/*.php") as $filename)
    {
        include $filename;
    }
$classes= getImplementingClasses("IMethod");

//Generating callable methods list
$MethodsList = Array();
foreach ($classes as $class){
    $MethodsList += [$class::CallableName=> $class];
}
if (!$DATA['method']){
    new APIResponse(new TheError(103));
}

//Method existence checking
if(array_key_exists($DATA['method'],$MethodsList)){

    $method = new $MethodsList[$DATA['method']]($DATA);

    //Method Params Verification
        if($method::RequireVerification || $method::RequireVerification === null ){
            if (property_exists($method,'ParamsList')){
                $params = $method::$ParamsList;
                $decision = true;
                foreach ($params as $param => $type){
                    if(!ParamsVerification::VerifyParam($DATA[$param],$type)){
                        $decision = false;
                        $failure = array("failed_param" =>$param, "failed_type" => $type);
                    }
                }
                if (!$decision) {
                    $wrong_parameter = "Parameter \"".$failure["failed_param"]. "\" should be ".$failure["failed_type"]. ".";
                    new APIResponse(new TheError(105,$wrong_parameter));
                }
            }else{
                new APIResponse(new TheError(104));
            }
        }



    //Исполнение метода
    $result = $method->Execute();
    new APIResponse($result);

}else{
   new APIResponse(new TheError(103));
}

?>