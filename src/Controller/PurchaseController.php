<?php

namespace App\Controller;

use App\Dto\CalculatePriceQueryDto;
use App\Dto\PurchaseQueryDto;
use App\Service\CalculatePriceService;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(#[MapRequestPayload] CalculatePriceQueryDto $calculatePriceQueryDto, CalculatePriceService $calculatePriceService,): JsonResponse
    {
        return $this->json($calculatePriceService->calculateFinalPrice($calculatePriceQueryDto));
    }

    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(#[MapRequestPayload] PurchaseQueryDto $purchaseQueryDto, PaymentService $paymentService): JsonResponse
    {
        if ($paymentService->process(100000, $purchaseQueryDto->paymentProcessor)) {
            return $this->json(['status' => true]);
        } else {
            return $this->json(['status' => false]);
        }
    }
}
