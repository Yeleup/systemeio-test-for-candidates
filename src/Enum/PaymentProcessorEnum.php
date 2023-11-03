<?php

namespace App\Enum;

enum PaymentProcessorEnum: string
{
    case PAYPAL = 'paypal';
    case STRIPE = 'stripe';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}