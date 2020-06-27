<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ShopUserRepository;
use App\Validators\ShopUserValidator;
use App\Http\Controllers\Controller;

/**
 * Class ShopUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class ShopUsersController extends Controller
{
    /**
     * ShopUsersController constructor.
     *
     * @param ShopUserRepository $repository
     * @param ShopUserValidator $validator
     */
    public function __construct()
    {
    }

}
