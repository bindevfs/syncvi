<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderProductRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderProductRepository extends RepositoryInterface
{
    //
    public function checkOwner($order_product_id);

    public function orderProductRequestingOfShop($shop_id);

    public function findAllOrderOfProduct($product_id, $shop_id);
}
