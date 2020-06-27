<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AdminRepository.
 *
 * @package namespace App\Repositories;
 */
interface AdminRepository extends RepositoryInterface
{
    public function allBuilder();

    public function newAdmin();

    public function getToken();

    public function createActivation($id);

    public function searchAdmin($search, $role, $perpage, $page);
}
