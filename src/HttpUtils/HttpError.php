<?php

namespace App\HttpUtils;

enum HttpError: int
{
    case UNAUTHORIZED = 200;
    case BAD_REQUEST = 400;
    case NOT_FOUNT = 404;

    public function getJsonMessage(): array
    {
        return match ($this) {
            self::UNAUTHORIZED => [
                'code' => self::UNAUTHORIZED,
                'error' => 'Unauthorized',
                'message' => 'Non sei autenticato, devi accedere prima di poter utilizzare il servizio',
            ],
            self::BAD_REQUEST => [
                'code' => self::BAD_REQUEST,
                'error' => 'Bad Request',
                'message' => 'Richiesta non è andata a buon fine!'
            ],
            self::NOT_FOUNT => [
                'code' => self::NOT_FOUNT,
                'error' => 'Not Found',
                'message' => 'Risorsa non trovata!',
            ]
        };
    }

    public function getWithCustomMessage(string $message): array
    {
        return [
            'code' => $this->getJsonMessage()['code'],
            'error' => $this->getJsonMessage()['error'],
            'message' => $message,
        ];
    }
}
