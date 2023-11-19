<?php

namespace Tests;

trait Funcs
{
    public function getStatus(): array
    {
        return [
            "result",
            "code",
            "nonce"
        ];
    }

    public function getSuccessResource(?array $resource = null): array
    {
        return [
            "status" => $this->getStatus(),
            "payloads" => is_null($resource) ? $this->resource : $resource,
        ];
    }

    public function getMetaResource(): array
    {
        return [
            "currentPage",
            "lastPage",
            "length",
            "getLength",
        ];
    }

    public function getIndexResource(?array $resource = null): array
    {
        return $this->getSuccessResource([
            "items" => [
                "*" =>  is_null($resource) ? $this->resource : $resource,
            ],
            "meta" => $this->getMetaResource(),
        ]);
    }
}