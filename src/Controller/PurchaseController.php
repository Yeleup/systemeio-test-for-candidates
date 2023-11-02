<?php

namespace App\Controller;

use App\Dto\CalculatePriceQueryDto;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\CalculatePriceService;
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
}
