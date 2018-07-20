<?php

namespace App\Tests\Repository;

use App\Entity\Banner;
use App\Repository\ArrayBannerRepository;
use PHPUnit\Framework\TestCase;

class ArrayBannerRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function givenADateThenFindAndSortAllActiveBanners()
    {
        $arrayBannerRepository = new ArrayBannerRepository();
        $arrayBannerRepository->setData([
            (new Banner())->setId('xigod321')->setPriority('10')->setTimeRange('4/1/2017-4/30/2017')->setUrl('https://some-url.com/lp/xigod321.html'),
            (new Banner())->setId('xigod324')->setPriority('10')->setTimeRange('10/1/2017-10/15/2017')->setUrl('https://some-url.com/lp/xigod324.html'),
        ]);

        $result = $arrayBannerRepository->findActive(new \DateTime('10/6/2017'));

        $banner = (new Banner)->setUrl('https://some-url.com/lp/xigod324.html')->setTimeRange('10/1/2017-10/15/2017')->setPriority('10')->setId('xigod324');
        $this->assertEquals([$banner], $result);
    }

    /**
     * @test
     */
    public function givenADateThenFindAndSortAllInactiveBanners()
    {
        $arrayBannerRepository = new ArrayBannerRepository();
        $arrayBannerRepository->setData([
            (new Banner())->setId('xigod321')->setPriority('20')->setTimeRange('4/1/2017-4/30/2017')->setUrl('https://some-url.com/lp/xigod321.html'),
            (new Banner())->setId('xigod324')->setPriority('10')->setTimeRange('10/1/2017-10/15/2017')->setUrl('https://some-url.com/lp/xigod324.html'),
        ]);

        $result = $arrayBannerRepository->findInactive(new \DateTime('1/20/2017'));

        $banner1 = (new Banner)->setUrl('https://some-url.com/lp/xigod321.html')->setTimeRange('4/1/2017-4/30/2017')->setPriority('20')->setId('xigod321');
        $banner2 = (new Banner)->setUrl('https://some-url.com/lp/xigod324.html')->setTimeRange('10/1/2017-10/15/2017')->setPriority('10')->setId('xigod324');
        $this->assertEquals([$banner1, $banner2], $result);
    }
}