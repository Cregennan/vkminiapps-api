
<?php
include 'VKSignVerifier.php';
include 'CustomSignVerifier.php';

/*
 * Verification methods:
 * VK: VKSignVerifier
 * Custom: CustomSignVerifier
 */

abstract class SignVerifier
{
    private $decision;

    /**
     * @param bool $decision
     * Decision of verification
     */
    protected function SetDecision(bool $decision){
        $this->decision = $decision;
    }
    public function GetDecision(){
        return $this->decision;
    }
    public abstract function __construct(array $params);

}