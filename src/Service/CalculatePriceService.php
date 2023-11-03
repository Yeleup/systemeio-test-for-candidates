<?php

namespace App\Service;

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

    public function calculateCart($productId, $couponCode, $taxNumber): array
    {
        $product = $this->productRepository->find($productId);
        $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);

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

        $countryCode = substr($taxNumber, 0, 2);
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