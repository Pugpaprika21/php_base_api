<?php

namespace App\Controllers;

use App\DI\Containerable;
use App\DTO\Http;
use App\DTO\Request\AppRequestable;
use App\DTO\Respone\AppResponeable;
use App\Foundation\Validator\Validable;
use App\Foundation\Validator\Validator;
use App\Services\GenerateObjableSarvice;
use Throwable;

class GenerateObjController extends BaseController
{
    private $env = null;

    private GenerateObjableSarvice $service;

    private ?Validable $validator;

    public function __construct(Containerable $container)
    {
        $this->env = $container->get("env");
        $this->service = $container->service(GenerateObjableSarvice::class);
        $this->validator = new Validator();
    }

    public function generate(AppRequestable $request, AppResponeable $respone)
    {
        try {
            $this->allow("POST");

            $rules = [
                "lang" => ["required", "max:10", "type:string"],
                "tb_name" => ["required", "max:50", "type:string"],
                "class_name" => ["required", "max:50", "type:string"],
            ];

            if (!$this->validator->validate($request::app()->json()["generate_rows"][0], $rules)) {
                echo $respone->status(Http::BAD_REQUEST)->message("bad request")->data($this->validator->errors())->toJSON();
                return;
            }

            if ($this->env["TOKEN_JWT"] != $this->bearerTokens()) {
                echo $respone->status(Http::UNAUTHORIZED)->message("unauthorized")->data($this->validator->errors())->toJSON();
                return;
            }

            $data = $this->service->generate($request);

            echo $respone->status(Http::OK)->message("Success")->data($data)->toJSON();
        } catch (Throwable $e) {
            echo $respone->status(Http::INTERNAL_SERVER_ERROR)->message($e->getMessage())->toJSON();
        }
    }
}
