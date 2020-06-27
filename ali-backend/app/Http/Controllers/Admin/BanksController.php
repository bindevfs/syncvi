<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BankCreateRequest;
use App\Http\Requests\BankUpdateRequest;
use App\Repositories\BankRepository;
use App\Validators\BankValidator;
use App\Http\Controllers\Controller;

/**
 * Class BanksController.
 *
 * @package namespace App\Http\Controllers;
 */
class BanksController extends Controller
{
    /**
     * @var BankRepository
     */
    protected $repository;

    /**
     * @var BankValidator
     */
    protected $validator;

    /**
     * BanksController constructor.
     *
     * @param BankRepository $repository
     * @param BankValidator $validator
     */
    public function __construct(BankRepository $repository, BankValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }
}
