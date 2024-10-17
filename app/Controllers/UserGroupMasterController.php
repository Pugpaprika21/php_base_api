<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Services\UserGroupMasterableService;
use Exception;

class UserGroupMasterController extends BaseController
{
    private ?UserGroupMasterableService $service;

    public function __construct(Containerable $container)
    {
        $this->service = $container->service(UserGroupMasterableService::class);
    }

    public function getUserGroupMaster(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

            $data = $this->service->getUserGroupMaster($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function creUserGroupMaster(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $data = $this->service->creUserGroupMaster($request);

            echo $respone->status(Http::CREATED)->message("Created")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function updUserGroupMaster(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("PUT");

            $data = $this->service->updUserGroupMaster($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function delUserGroupMaster(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("DELETE");

            $data = $this->service->delUserGroupMaster($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
