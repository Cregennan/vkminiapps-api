<?php


class CustomSignVerifier extends SignVerifier
{

    public function __construct(array $params)
    {
        $this->SetDecision(false);
    }
}