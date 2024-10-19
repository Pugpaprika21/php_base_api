<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Services\UserGroupSettingableService;
use Throwable;

class UserGroupSettingController extends BaseController
{
    private ?UserGroupSettingableService $service;

    public function __construct(?Containerable $container)
    {
        $this->service = $container->service(UserGroupSettingableService::class);
    }

    public function getUsersGroupSetting(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

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
