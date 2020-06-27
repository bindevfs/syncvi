<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repositories\OrderProductRepository;
use App\Validators\OrderProductValidator;
use App\Http\Controllers\Controller;

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
     * OrderProductsController constructor.
     *
     * @param OrderProductRepository $repository
     * @param OrderProductValidator $validator
     */
    public function __construct(OrderProductRepository $repository, OrderProductValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }
}
