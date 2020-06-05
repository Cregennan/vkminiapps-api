<?php


final class TheSuccess implements IReturnable
{
    private $data;

    /**
     * TheSuccess constructor  - creates success response to API
     * @param mixed $DATA Data for API to return. If null, message in $extra is shown
     * @param string $extra Extra message, null in default
     */
    public function __construct($DATA, $extra = null)
    {
        if($DATA){
            $this->data = $DATA;
        }else{
            $this->data = array(
                "response"=>$extra
            );
        }
    }

    /**
     * @return mixed Data to API
     */
    public function getData()
    {
        return $this->data;
    }

}