<?php

namespace App\HttpUtils;

enum HttpError: int
{
    case UNAUTHORIZED = 200;
    case NOT_FOUNT = 404;

    public function getJsonMessage(): array
    {
        return match ($this) {
            self::UNAUTHORIZED => [
                'code' => self::UNAUTHORIZED,
                'error' => 'Unauthorized',
                'message' => 'Non sei autenticato, devi accedere prima di poter utilizzare l\'endpoint!',
            ],
            self::NOT_FOUNT => [
                'code' => self::NOT_FOUNT,
                'error' => 'Not Found',
                'message' => 'Risorsa non trovata!',
            ]
        };
    }
}
