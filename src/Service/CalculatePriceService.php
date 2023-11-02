<?php

namespace App\Service;

use App\Dto\CalculatePriceQueryDto;
use App\Entity\Coupon;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Repository\CouponRepository;

class CalculatePriceService
{
    private ProductRepository $productRepository;
    private TaxRepository $taxRepository;
    private CouponRepository $couponRepository;

    public function __construct(
        ProductRepository $productRepository,
        TaxRepository $taxRepository,
        CouponRepository $couponRepository
    ) {
        $this->productRepository = $productRepository;
        $this->taxRepository = $taxRepository;
        $this->couponRepository = $couponRepository;
    }

    public function calculateFinalPrice(CalculatePriceQueryDto $calculatePriceQueryDto): array
    {
        $product = $this->productRepository->find($calculatePriceQueryDto->product);
        $coupon = $this->couponRepository->findOneBy(['code' => $calculatePriceQueryDto->couponCode]);

        $price = $product->getPrice();

        $couponPrice = 0;

        if ($coupon) {
            if ($coupon->getType() == Coupon::TYPE_PERCENT) {
                $couponPrice = $price * ($coupon->getValue() / 100);
            } elseif($coupon->getType() == Coupon::TYPE_FIX) {
                $couponPrice = $coupon->getValue();
            }
            $price -= $couponPrice;
        }

        $countryCode = substr($calculatePriceQueryDto->taxNumber, 0, 2);
        $tax = $this->taxRepository->findOneBy(['countryCode' => $countryCode]);
        $taxPrice = $price * ($tax->getRate() / 100);

        $price += $taxPrice;

        return [
            'product' => $product->getPrice(),
            'tax' => $taxPrice,
            'coupon' => [
                'value' => $couponPrice,
                'type' => $coupon?->getType()
            ],
            'total' => $price,
        ];
    }
}