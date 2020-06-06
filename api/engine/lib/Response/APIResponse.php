<?php


class APIResponse
{
    public function __construct(IReturnable $Response)
    {
        header('Content-type: text/html; charset=utf-8');
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
        exit(json_encode($result));
    }
}