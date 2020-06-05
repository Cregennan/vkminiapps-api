<?php
include 'SignVerifier.php';
$VerificationPrints = array(
    'sign' => 'VKSignVerifier',
    'custom_sign' => 'CustomSignVerifier'
);
function SignVerification(array $params){
    global $VerificationPrints;
    foreach ($VerificationPrints as $print => $method){
        if (isset($params[$print])){
            $Verifier = new $VerificationPrints[$print]($params);
            return $Verifier->GetDesicion();

        }
    }
    return false;
}