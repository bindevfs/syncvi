<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ShopUserRepository.
 *
 * @package namespace App\Repositories;
 */
interface ShopUserRepository extends RepositoryInterface
{
    public function countShopUser($shop_id);

    public function allBuilder($shop_id);

    public function newShopUser($shop_id);
}
