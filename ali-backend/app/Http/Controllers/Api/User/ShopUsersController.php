<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
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
