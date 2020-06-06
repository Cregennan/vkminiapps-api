<?php
/**
 * @author RadioNurshat
 * @version 2.0.0
 * Entry point of RNAPI, VKTaxi edition
 *
 */
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
include 'engine/lib.php';
include 'engine/config.php';

$DATA = $_GET;

new APIResponse(new TheError(101,'Неужели ты настолько долбоеб, что не смог сделать нормальный метод апи?'));
if (SIGN_VERIFICATION_REQUIRED){
    $IsVerified = SignVerification($DATA);
    if (!$IsVerified){
        /**
         * TODO: Генерация ошибки проверки подписи (После создания соответствующей системы)
         * TODO: Создать систему единой генерации ответа и ошибок
         */


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
    //TODO Ошибка запроса к АПИ: не указан вызываемый метод
    echo("Method not given");
}

//Method existence checking
if(array_key_exists($DATA['method'],$MethodsList)){

    $method = new $MethodsList[$DATA['method']]($DATA);

    //Method Params Verification
    if(PARAMS_VERIFICATION_REQUIRED){
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
                    echo("Params verification failed");
                    echo("Parameter \"".$failure["failed_param"]. "\" should be ".$failure["failed_type"]. ".");
                    //TODO Ошибка верификации параметров запроса
                }
            }else{
                //TODO Ошибка АПИ: не обьявлены входные параметры
                echo("Params not declared");
            }
        }
    }



    $result = $method->Execute();


    /**
     * TODO Вызов метода
     */

}else{
    /**
     * TODO Ошибка АПИ: вызываемый метод не существует
     */
    echo ('No such api method');
}

?>