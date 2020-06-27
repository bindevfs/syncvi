<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShopRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShopRepository extends RepositoryInterface
{
    public function allBuilder();

    public function newShop();

    public function searchShop($role,$search,$sort,$option,$perpage,$page);
}
