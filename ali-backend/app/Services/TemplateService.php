<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class TemplateService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function renameThisFunctionIfYouWant(Request $request)
    {
       //Do something
    }
}
/*Construct of Controller must be change like this:
    protected $templateService;
    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }
    And user service like this:
    $this->templateService->renameThisFunctionIfYouWant($request);
*/
