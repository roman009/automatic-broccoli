<?php

namespace App\Tests\Application\Services;

use App\Application\Services\ActiveBannerService;
use App\Repository\BannerRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ActiveBannerServiceTest extends TestCase
{
    /**
     * @test
     */
    public function givenARequestAndNotWhiteListedIpThenCallActive()
    {
        $allowedIps = '10.1.3.1';
        $bannerRepository = $this->getMockBuilder(BannerRepository::class)
            ->setMethods(['findActive', 'load', 'findInactive'])
            ->getMock();
        $bannerRepository->expects($this->once())->method('findActive');
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['get'])
            ->getMock();
        $request->expects($this->once())->method('get')->willReturn('5/1/2017');

        $activeBannerService = new ActiveBannerService($allowedIps, $bannerRepository);
        $result = $activeBannerService->find($request);

        $this->assertSame([], $result);
    }

    /**
     * @test
     */
    public function givenARequestAndWhiteListedIpThenCallInactive()
    {
        $allowedIps = '10.1.3.1';
        $bannerRepository = $this->getMockBuilder(BannerRepository::class)
            ->setMethods(['findActive', 'load', 'findInactive'])
            ->getMock();
        $bannerRepository->expects($this->once())->method('findInactive');
        $request = $this->getMockBuilder(Request::class)
            ->setMethods(['get', 'getClientIp'])
            ->getMock();
        $request->expects($this->once())->method('get')->willReturn('5/1/2017');
        $request->expects($this->once())->method('getClientIp')->willReturn('10.1.3.1');

        $activeBannerService = new ActiveBannerService($allowedIps, $bannerRepository);
        $result = $activeBannerService->find($request);

        $this->assertSame([], $result);
    }
}