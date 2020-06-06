<?php


interface ISignVerifier{
    public function GetDecision();
    public function __construct(array $params);
}