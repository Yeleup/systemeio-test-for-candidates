<?php
namespace App\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor as BasePaymentProcessor;

class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(protected BasePaymentProcessor $paymentProcessor)
    {
    }

    public function processPayment($amount) {
        $this->paymentProcessor->pay($amount);
        return true;
    }
}