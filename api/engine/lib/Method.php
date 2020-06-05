<?php

function getImplementingClasses( $interfaceName ) {
    return array_filter(
        get_declared_classes(),
        function( $className ) use ( $interfaceName ) {
            return in_array( $interfaceName, class_implements( $className ) );
        }
    );
}
interface IMethod{
    public function __construct(array $inputData);
    public function Execute(): IReturnable;
}

/**
 * Class Method
 * Every callable class should have public constant "CallableName", that will be used as name of the method in API
 */
abstract class method
{
    public abstract function Execute(): IReturnable;

    /**
     * Method constructor.
     * @param array $data
     */
    public final function __construct(array $data){
        $this->data = $data;
    }

    protected $data;
    protected $result;

    /**
     * @return IReturnable Error or Success
     */


    /**
     * @param IReturnable $result TheError or TheSuccess for API to return
     */
    public function setResult(IReturnable $result): void
    {
        $this->result = $result;
    }


}