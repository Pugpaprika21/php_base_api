<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Services\UserGroupableService;
use Throwable;

class UserGroupController extends BaseController
{
    private ?UserGroupableService $service;

    public function __construct(Containerable $container)
    {
        $this->service = $container->service(UserGroupableService::class);
    }

    public function getUserGroup(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

            $data = $this->service->getUserGroup($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function creUserGroup(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $data = $this->service->creUserGroup($request);

            echo $respone->status(Http::CREATED)->message("Created")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function updUserGroup(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("PUT");

            $data = $this->service->updUserGroup($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function delUserGroup(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("DELETE");

            $data = $this->service->delUserGroup($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
