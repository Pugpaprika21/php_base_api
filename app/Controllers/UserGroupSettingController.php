<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Foundation\Validator\Validable;
use App\Foundation\Validator\Validator;
use App\Services\UserGroupSettingableService;
use Throwable;

class UserGroupSettingController extends BaseController
{
    private ?UserGroupSettingableService $service;

    private ?Validable $validator;

    public function __construct(?Containerable $container)
    {
        $this->service = $container->service(UserGroupSettingableService::class);
        $this->validator = new Validator();
    }

    public function getUsersGroupSetting(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

            $rules = [
                "user_id" => ["required", "type:string"],
            ];

            if (!$this->validator->validate($request::app()->get(), $rules)) {
                echo $respone->status(Http::BAD_REQUEST)->message("bad request")->data($this->validator->errors())->toJSON();
                return;
            }

            $data = $this->service->getUsersGroupSetting($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function creUsersGroupSetting(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $data = $this->service->creUsersGroupSetting($request);

            echo $respone->status(Http::CREATED)->message("Created")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
