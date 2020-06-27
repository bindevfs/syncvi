<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    //
    public function allOrderUser($user_id);

    public function findOrderForShop($shop_id);

    public function findNewOrderForShop($shop_id);

    public function findAuthenticatedOrderForShop($shop_id);

    public function countOrderForShop($shop_id);

    public function countOrderForUser($user_id);

    public function searchOrder($role,$search,$shop,$price1,$price2,$date1,$date2,$sort,$perpage,$page);

    public function calChartForShop($shop_id);

    public function chartOrder($shop_id, $option);

    public function removeProductForOrder($product_id);
}
