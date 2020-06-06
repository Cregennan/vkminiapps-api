<?php


class APIResponse
{
    public function __construct(IReturnable $Response)
    {
        $status = '';
        if($Response instanceof TheSuccess){
            $status = 'success';
        }
        if ($Response instanceof  TheError){
            $status = 'error';
        }
        $result = array(
            "status" => $status,
            "response" => $Response->getData()
        );
        exit(json_encode($result,JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK));
    }
}