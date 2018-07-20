<?php

namespace App\Application\Services;

use App\Repository\BannerRepository;
use Symfony\Component\HttpFoundation\Request;

class ActiveBannerService
{
    private $allowedIps;
    private $bannerRepository;

    public function __construct(string $allowedIps, BannerRepository $bannerRepository)
    {
        $this->allowedIps = explode(',', $allowedIps);
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function find(Request $request)
    {
        $userIp = $request->getClientIp();
        $date = new \DateTime($request->get('date'));
        if (in_array($userIp, $this->allowedIps)) {
            // handle white listed ips
            $banners = $this->bannerRepository->findInactive($date);
        } else {
            $banners = $this->bannerRepository->findActive($date);
        }

        return $banners[0] ?? [];
    }
}
