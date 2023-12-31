<?php
namespace App\Service;

use App\Enum\PaymentProcessorEnum;
use App\PaymentProcessor\PaymentProcessorInterface;
use App\PaymentProcessor\PaypalPaymentProcessorAdapter;
use App\PaymentProcessor\StripePaymentProcessorAdapter;

class PaymentService {
    private array $paymentProcessors;

    public function __construct(iterable $paymentProcessors) {
        foreach ($paymentProcessors as $processor) {
            if (!$processor instanceof PaymentProcessorInterface) {
                throw new \InvalidArgumentException('Invalid payment processor provided');
            }

            if ($processor instanceof PaypalPaymentProcessorAdapter) {
                $this->paymentProcessors[PaymentProcessorEnum::PAYPAL->value] = $processor;
            } elseif ($processor instanceof StripePaymentProcessorAdapter) {
                $this->paymentProcessors[PaymentProcessorEnum::STRIPE->value] = $processor;
            }
        }
    }

    public function process($amount, $processorType) {
        if (!isset($this->paymentProcessors[$processorType])) {
            throw new \InvalidArgumentException('Payment processor type not supported');
        }
        return $this->paymentProcessors[$processorType]->processPayment($amount);
    }
}