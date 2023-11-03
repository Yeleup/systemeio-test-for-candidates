<?php
namespace App\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor as BasePaymentProcessor;

class StripePaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(protected BasePaymentProcessor $paymentProcessor)
    {
    }

    public function processPayment($amount) {
        return $this->paymentProcessor->processPayment($amount);
    }
}