<?php
/**
 * Class VKSignVerifier
 *
 */
class VKSignVerifier extends SignVerifier
{
    public function __construct(array $params)
    {
        //Тестовый адрес с vkTaxi = https://56b18fa4.ngrok.io/?vk_access_token_settings=notify%2Cmenu&vk_app_id=7311997&vk_are_notifications_enabled=0&vk_is_app_user=1&vk_is_favorite=0&vk_language=ru&vk_platform=desktop_web&vk_ref=other&vk_user_id=395487207&sign=4MfpMCfI5RyxYxgLqlOtdicGZp2Qh2MmHcDwfFucBc8
        $client_secret = VK_PROTECTED_KEY;
        $query_params = $params;
        $sign_params = [];
        foreach ($query_params as $name => $value) {
            if (strpos($name, 'vk_') !== 0) { // Получаем только vk параметры из query
                continue;
            }
            $sign_params[$name] = $value;
        }
        ksort($sign_params); // Сортируем массив по ключам
        $sign_params_query = http_build_query($sign_params); // Формируем строку вида "param_name1=value&param_name2=value"
        $sign = rtrim(strtr(base64_encode(hash_hmac('sha256', $sign_params_query, $client_secret, true)), '+/', '-_'), '='); // Получаем хеш-код от строки, используя защищеный ключ приложения. Генерация на основе метода HMAC.
        $status = $sign === $query_params['sign']; // Сравниваем полученную подпись со значением параметра 'sign'

        $this->SetDecision($status);

    }
}