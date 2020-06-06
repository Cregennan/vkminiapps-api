<?php


interface IReturnable
{
public function __construct($DATA, string $extra);
public function getData();
}