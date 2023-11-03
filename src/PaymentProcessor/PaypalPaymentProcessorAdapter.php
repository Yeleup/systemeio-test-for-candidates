<?php
namespace App\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor as BasePaymentProcessor;

class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(protected BasePaymentProcessor $paymentProcessor)
    {
    }

    public function processPayment($amount): bool
    {
        try {
            $this->paymentProcessor->pay($amount);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}