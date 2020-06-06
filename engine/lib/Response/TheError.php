<?php
$file = file_get_contents(__DIR__.'\error_types.json');
$ErrorTypes = json_decode($file);

final class TheError implements IReturnable
{
    private $data = array();

    /**
     * TheError constructor - creates error response to API
     * @param mixed $ErrorType Error id for API to return
     * @param string $extra If given, additional error data will be added to response
     */
    public function __construct($ErrorType, string $extra = null)
    {
        global $ErrorTypes;
        $error = null;
        switch (gettype($ErrorType)){

            case "string":
                foreach ($ErrorTypes as $errorType){
                    if ($errorType->code == $ErrorType){
                        $error = $errorType;
                        break;
                    }
                }
                break;
            case "integer":
                foreach ($ErrorTypes as $errorType){
                    if ($errorType->id == $ErrorType){
                        $error = $errorType;
                        break;
                    }
                }
                break;
        }

        if ($error){
            $this->data = get_object_vars($error);
            if ($extra){
                $this->data +=["extra"=>$extra];
            }
        }else{
            $this->data = get_object_vars($ErrorTypes[0]);
        }

    }

    /**
     * @return array Array-formatted error data
     */
    public function getData(): array
    {
        return $this->data;
    }
}