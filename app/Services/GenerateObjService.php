<?php

namespace App\Services;

use App\DI\Containerable;
use App\DTO\Request\AppRequestable;
use App\Repository\GenerateObjableRepository;

class GenerateObjService implements GenerateObjableService
{
    private ?GenerateObjableRepository $repository;

    public function __construct(Containerable $container)
    {
        $this->repository = $container->repository(GenerateObjableRepository::class);
    }

    public function generate(AppRequestable $request)
    {
        $data = [];
        $body = $request::app()->json();
    
        foreach ($body["generate_rows"] as $row) {
            if (empty($row["tb_name"]) || empty($row["class_name"])) {
                continue;
            }
    
            $rows = $this->repository->generate($row["tb_name"], $row["class_name"]);
            if (empty($rows)) {
                continue; 
            }
    
            $creFileDatetime = date("YmdHis");
            $className = $this->convertToCamelCase($row["class_name"]);
            if ($row["lang"] === "php") {
                $this->generatePhpClass($className, $rows, $creFileDatetime, $row["class_name"]);
            } elseif ($row["lang"] === "golang") {
                $this->generateGoStruct($className, $rows, $creFileDatetime, $row["class_name"]);
            }
        }
    
        return $data;
    }
    
    private function generatePhpClass($className, $rows, $creFileDatetime, $originalClassName)
    {
        $classProperties = [];
        foreach ($rows as $field => $type) {
            $phpType = $this->mapMysqlTypeToPhpType($type);
            $classProperties[] = "    public $phpType \$$field;";
        }
        $classContent = "<?php\n\nclass $className\n{\n" . implode("\n", $classProperties) . "\n}\n";
    
        $classFilePath = "public/generate/php/{$originalClassName}_{$creFileDatetime}_.php";
        file_put_contents($classFilePath, $classContent);
    }
    
    private function generateGoStruct($className, $rows, $creFileDatetime, $originalClassName)
    {
        $goStructFields = [];
        foreach ($rows as $field => $type) {
            $goType = $this->mapMysqlTypeToGoType($type);
            $camelCaseField = $this->convertToCamelCase($field);
            $goStructFields[] = "    $camelCaseField $goType `json:\"$field\"`";
        }
        $goStructContent = "package main\n\ntype $className struct {\n" . implode("\n", $goStructFields) . "\n}\n";
    
        $goFilePath = "public/generate/golang/{$originalClassName}_{$creFileDatetime}_.go";
        file_put_contents($goFilePath, $goStructContent);
    }
    

    private function mapMysqlTypeToPhpType($mysqlType)
    {
        if (strpos($mysqlType, "int") !== false) {
            return "int";
        } elseif (strpos($mysqlType, "varchar") !== false || strpos($mysqlType, "text") !== false) {
            return "string";
        } elseif (strpos($mysqlType, "decimal") !== false || strpos($mysqlType, "float") !== false) {
            return "float";
        } elseif (strpos($mysqlType, "date") !== false || strpos($mysqlType, "time") !== false || strpos($mysqlType, "datetime") !== false) {
            return "string";
        } else {
            return "mixed";
        }
    }

    private function mapMysqlTypeToGoType($mysqlType)
    {
        if (strpos($mysqlType, "int") !== false) {
            return "int";
        } elseif (strpos($mysqlType, "varchar") !== false || strpos($mysqlType, "text") !== false) {
            return "string";
        } elseif (strpos($mysqlType, "decimal") !== false || strpos($mysqlType, "float") !== false) {
            return "float64"; 
        } elseif (strpos($mysqlType, "date") !== false || strpos($mysqlType, "time") !== false || strpos($mysqlType, "datetime") !== false) {
            return "string";
        } else {
            return "interface{}"; 
        }
    }

    private function convertToCamelCase($string)
    {
        $string = strtolower($string);
        $parts = explode("_", $string);
        $camelCase = "";

        foreach ($parts as $part) {
            $camelCase .= ucfirst($part);
        }

        return $camelCase;
    }
}
