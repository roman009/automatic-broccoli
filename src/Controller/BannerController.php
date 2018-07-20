<?php

namespace App\Controller;

use App\Application\Services\ActiveBannerService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BannerController
{
    /**
     * @Route("/", methods={"GET"})
     * @param Request $request
     * @param ActiveBannerService $activeBannerService
     * @return JsonResponse
     */
    public function index(Request $request, ActiveBannerService $activeBannerService): JsonResponse
    {
        return new JsonResponse($activeBannerService->find($request));
    }
}
