<?php

namespace App\Http\Controllers\Api\Shop;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Repositories\OrderProductRepository;
use App\Validators\OrderProductValidator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * Class OrderProductsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OrderProductsController extends Controller
{
    /**
     * @var OrderProductRepository
     */
    protected $repository;

    /**
     * @var OrderProductValidator
     */
    protected $validator;

    /**
     * @var OrderRepository
     */
    protected $orderRepo;
    /**
     * OrderProductsController constructor.
     *
     * @param OrderProductRepository $repository
     * @param OrderProductValidator $validator
     */
    public function __construct(OrderProductRepository $repository, OrderProductValidator $validator, OrderRepository $orderRepo)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->orderRepo = $orderRepo;
    }

}
