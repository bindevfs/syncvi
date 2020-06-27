<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BillCreateRequest;
use App\Http\Requests\BillUpdateRequest;
use App\Repositories\BillRepository;
use App\Validators\BillValidator;
use App\Http\Controllers\Controller;

/**
 * Class BillsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BillsController extends Controller
{
    /**
     * @var BillRepository
     */
    protected $repository;

    /**
     * @var BillValidator
     */
    protected $validator;

    /**
     * BillsController constructor.
     *
     * @param BillRepository $repository
     * @param BillValidator $validator
     */
    public function __construct(BillRepository $repository, BillValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }
}
