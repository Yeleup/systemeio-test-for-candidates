<?php
namespace App\Dto;
use App\Enum\PaymentProcessorEnum;
use App\Validator\IsCorrectTaxNumber;
use App\Validator\ProductExists;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseQueryDto
{
    public function __construct(
        #[Assert\Type('integer'), Assert\NotNull, ProductExists]
        public readonly int $product,

        #[Assert\Type('string'), Assert\NotNull, IsCorrectTaxNumber]
        public readonly string $taxNumber,

        #[Assert\Type('string'), Assert\NotBlank]
        public readonly string $couponCode,

        #[Assert\NotNull, Assert\Choice(callback: [PaymentProcessorEnum::class, 'values'])]
        public readonly string $paymentProcessor,
    ) {
    }
}