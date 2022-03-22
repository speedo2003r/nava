<?php

namespace App\Http\Controllers\Api\Client;
use App\Entities\Question;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Contact\ContactRequest;
use App\Http\Resources\Questions\QuestionResource;
use App\Http\Resources\Settings\pageResource;
use App\Repositories\ContactUsRepository;
use App\Repositories\PageRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PageController extends Controller{

    use ResponseTrait;
    public $userRepo,$pageRepo,$contactRepo;
    public function __construct(UserRepository $user,PageRepository $pageRepo,ContactUsRepository $contactRepo)
    {
        $this->userRepo = $user;
        $this->pageRepo = $pageRepo;
        $this->contactRepo = $contactRepo;
    }

    public function questions(Request $request)
    {
        $questions = Question::latest()->get();
        return $this->successResponse(QuestionResource::collection($questions));
    }

    public function About(Request $request)
    {
        return $this->successResponse(new pageResource($this->pageRepo->find(1)));
    }

    public function Policy(Request $request)
    {
        return $this->successResponse(new pageResource($this->pageRepo->find(2)));
    }
    public function ContactMessage(ContactRequest $request)
    {
        $data = array_filter($request->all());
        $this->contactRepo->create($data);
        return $this->successResponse();
    }
}
