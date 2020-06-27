<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProductRepository.
 *
 * @package namespace App\Repositories;
 */
interface ProductRepository extends RepositoryInterface
{
    public function allBuilder();

    public function newProduct();

    public function whereIn($col, $arr);

    public function searchProduct($shop_id, $search, $price1, $price2, $date1, $date2, $perpage, $page);

    public function chartProduct($shop_id, $option);

    public function allProduct($shop_id);
}
