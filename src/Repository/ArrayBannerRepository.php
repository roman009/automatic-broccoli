<?php

namespace App\Repository;

use App\Entity\Banner;

class ArrayBannerRepository implements BannerRepository
{
    private $data;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function load(): array
    {
        return $this->data ?? [
            (new Banner())->setId('xigod321')->setPriority('10')->setTimeRange('4/1/2017-4/30/2017')->setUrl('https://some-url.com/lp/xigod321.html'),
            (new Banner())->setId('xigod322')->setPriority('10')->setTimeRange('5/1/2017-8/31/2017')->setUrl('https://some-url.com/lp/xigod322.html'),
            (new Banner())->setId('xigod323')->setPriority('5')->setTimeRange('3/1/2017-12/31/2017')->setUrl('https://some-url.com/lp/xigod323.html'),
            (new Banner())->setId('xigod324')->setPriority('20')->setTimeRange('10/1/2017-10/15/2017')->setUrl('https://some-url.com/lp/xigod324.html'),
            (new Banner())->setId('xigod325')->setPriority('20')->setTimeRange('4/15/2017-5/14/2017')->setUrl('https://some-url.com/lp/xigod325.html'),
        ];
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    public function findActive(\DateTime $date): array
    {
        $banners = $this->load();
        $banners = $this->filterActive($banners, $date);

        return $this->sort($banners);
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    public function findInactive(\DateTime $date): array
    {
        $banners = $this->load();
        $banners = $this->filterInactive($banners, $date);

        return $this->sort($banners);
    }

    private function filterActive(array $banners, \DateTime $date): array
    {
        return array_filter($banners, function (Banner $banner) use ($date) {
            $dates = explode('-', $banner->getTimeRange());
            $bannerStartDate = new \DateTime($dates[0]);
            $bannerEndDate = new \DateTime($dates[1]);

            return $bannerStartDate <= $date && $date <= $bannerEndDate;
        });
    }

    private function filterInactive(array $banners, \DateTime $date): array
    {
        return array_filter($banners, function (Banner $banner) use ($date) {
            $dates = explode('-', $banner->getTimeRange());
            $bannerEndDate = new \DateTime($dates[1]);

            return $date < $bannerEndDate;
        });
    }

    private function sort(array $banners): array
    {
        usort($banners, function (Banner $a, Banner $b) {
            if ($a->getPriority() === $b->getPriority()) {
                return strcmp($a->getId(), $b->getId());
            }

            return ($a->getPriority() < $b->getPriority()) ? 1 : -1;
        });

        return $banners;
    }
}
