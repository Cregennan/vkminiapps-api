<?php
$file = file_get_contents('./error_types.json');
$ErrorTypes = json_decode($file);

final class TheError implements IReturnable
{
    private $data = array();

    /**
     * TheError constructor - creates error response to API
     * @param mixed $DATA Error data for API to return
     * @param string $extra If given, additional error data will be added to response
     */
    public function __construct($DATA, string $extra = null)
    {
        global $ErrorTypes;
        $error = null;
        switch (gettype($DATA)){

            case "string":
                foreach ($ErrorTypes as $errorType){
                    if ($errorType->code == $DATA){
                        $error = $errorType;
                        break;
                    }
                }
                break;
            case "integer":
                foreach ($ErrorTypes as $errorType){
                    if ($errorType->id == $DATA){
                        $error = $errorType;
                        break;
                    }
                }
                break;
        }
        if ($error){
            $this->data = $error;
            if ($extra){
                $this->data +=["extra"=>$extra];
            }
        }else{
            $this->data = $ErrorTypes[0];
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