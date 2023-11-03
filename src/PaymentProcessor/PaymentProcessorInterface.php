<?php
namespace App\PaymentProcessor;

interface PaymentProcessorInterface {
    public function processPayment($amount): bool;
}