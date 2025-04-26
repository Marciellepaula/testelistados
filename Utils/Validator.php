<?php

class Validator
{
    public static function sanitize($data)
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    public static function validatePrice($price)
    {
        if (!is_numeric($price) || $price <= 0) {
            throw new Exception(' Preço inválido.');
        }
        return $price;
    }

    public static function validateGaragem($garagem)
    {
        if (!is_numeric($garagem) || $garagem < 0) {
            throw new Exception(' Número de garagens inválido.');
        }
        return $garagem;
    }
}
