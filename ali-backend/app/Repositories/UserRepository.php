<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserRepository extends RepositoryInterface
{
    public function allBuilder();

    public function newUser();

    public function searchUser($role, $search, $sort, $perpage, $page);
}
