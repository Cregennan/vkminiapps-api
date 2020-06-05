<?php
/**
 * Class VKSignVerifier
 *
 */
class VKSignVerifier extends SignVerifier
{
    public function __construct(array $params)
    {
        /**
         * TODO: Заменить эту временную заглушку на нормальную проверку подписи ВК
         */
        $this->SetDecision(true);

    }
}