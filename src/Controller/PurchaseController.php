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
    public function __construct(protected CalculatePriceService $calculatePriceService)
    {
    }

    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function calculatePrice(#[MapRequestPayload] CalculatePriceQueryDto $dto): JsonResponse
    {
        return $this->json($this->calculatePriceService->calculateCart($dto->product, $dto->couponCode, $dto->taxNumber));
    }

    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(#[MapRequestPayload] PurchaseQueryDto $dto, PaymentService $paymentService): JsonResponse
    {
        $result = $this->calculatePriceService->calculateCart($dto->product, $dto->couponCode, $dto->taxNumber);

        if ($paymentService->process($result['total'], $dto->paymentProcessor)) {
            return $this->json(['status' => true]);
        } else {
            return $this->json(['status' => false]);
        }
    }
}
