<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\ShopRepository;
use App\Validators\ShopValidator;
use App\Http\Controllers\Controller;

/**
 * Class ShopsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ShopsController extends Controller
{
    /**
     * ShopsController constructor.
     *
     * @param ShopRepository $repository
     * @param ShopValidator $validator
     */
    public function __construct()
    {
    }

}
