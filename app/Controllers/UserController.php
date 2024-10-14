<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\Controllers\BaseController as MistineController;
use App\DTO\Http;
use App\DTO\Request\AppableRequest;
use App\Repository\UserableRepository;
use App\Services\UserableService;
use Exception;

class UserController extends MistineController
{
    private ?UserableRepository $repository;

    private ?UserableService $service;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserableRepository::class);
        $this->service = $container->service(UserableService::class);
    }

    public function getUsers()
    {
        try {
            $this->allow("GET");
            $users = $this->repository->findAll();
            echo $this->toJSON($users, Http::OK);
        } catch (Exception $e) {
            echo $this->toJSON(["error" => $e->getMessage()], Http::INTERNAL_SERVER_ERROR);
        }
    }

    public function getUser(AppableRequest $request)
    {
        try {
            $this->allow("GET");
            $user = $this->repository->findOne($request);
            echo $this->toJSON($user, Http::OK);
        } catch (Exception $e) {
            echo $this->toJSON(["error" => $e->getMessage()], Http::INTERNAL_SERVER_ERROR);
        }
    }

    public function createUser(AppableRequest $request)
    {
        try {
            $this->allow("POST");
            $result = $this->repository->createUser($request);
            echo $this->toJSON($result, Http::CREATED);
        } catch (Exception $e) {
            echo $this->toJSON(["error" => $e->getMessage()], Http::INTERNAL_SERVER_ERROR);
        }
    }
}
