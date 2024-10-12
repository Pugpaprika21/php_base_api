<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\Controllers\BaseController as MistineController;
use App\DTO\Http;
use App\Repository\UserableRepository;
use Exception;

class UserController extends MistineController
{
    private ?UserableRepository $repository;

    public function __construct(?Containerable $container)
    {
        $this->repository = $container->repository(UserableRepository::class);
    }

    public function getUsers()
    {;
        try {
            $users = $this->repository->findAll();
            echo $this->toJSON($users, Http::OK);
        } catch (Exception $e) {
            echo $this->toJSON(["error" => $e->getMessage()], Http::INTERNAL_SERVER_ERROR);
        }
    }
}
