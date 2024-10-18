<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\Controllers\BaseController;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Foundation\Validator\Validable;
use App\Foundation\Validator\Validator;
use App\Services\UserableService;
use Throwable;

class UserController extends BaseController
{
    private ?UserableService $service;

    private ?Validable $validator;

    public function __construct(?Containerable $container)
    {
        $this->service = $container->service(UserableService::class);
        $this->validator = new Validator();
    }

    public function getUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

            $data = $this->service->getUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function creUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $rules = [
                "username" => ["required", "min:5", "max:10", "type:string"],
                "password" => ["required", "max:50", "type:string"],
            ];

            if (!$this->validator->validate($request::app()->json()["users_rows"][0], $rules)) {
                echo $respone->status(Http::BAD_REQUEST)->message("bad request")->data($this->validator->errors())->toJSON();
                return;
            }

            $data = $this->service->creUsers($request);

            echo $respone->status(Http::CREATED)->message("Created")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function updUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("PUT");

            $data = $this->service->updUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function delUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("DELETE");

            $data = $this->service->delUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
