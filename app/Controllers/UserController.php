<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\Controllers\BaseController as MistineController;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Services\UserableService;
use Exception;

class UserController extends MistineController
{
    private ?UserableService $service;

    public function __construct(?Containerable $container)
    {
        $this->service = $container->service(UserableService::class);
    }

    public function getUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("GET");

            $data = $this->service->getUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function creUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $data = $this->service->creUsers($request);

            echo $respone->status(Http::CREATED)->message("Created")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function updUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("PUT");

            $data = $this->service->updUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }

    public function delUsers(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("DELETE");

            $data = $this->service->delUsers($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Exception $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
