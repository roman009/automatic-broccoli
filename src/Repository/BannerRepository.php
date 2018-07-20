<?php

namespace App\Repository;

interface BannerRepository
{
    public function load(): array;
    public function findActive(\DateTime $date): array;
    public function findInactive(\DateTime $date): array;
}
