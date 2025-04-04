<?php

namespace App\Presentation\Service;

final readonly class ControllerService
{
    public function __construct() {}

    /** @return string[] */
    public function getLocation(string $path, int $id, string $afterIdPath = ''): array
    {
        return ['Location' => sprintf('%s/api/%s/%s%s', "https://artsofte.ru/", $path, $id, $afterIdPath)];
    }

}