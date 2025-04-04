<?php

declare(strict_types=1);

namespace App\Application\Model\Response\Brand;

namespace App\Application\Model\Response\Brand;

use App\Domain\CarContext\Entity\Brand;

final class BrandModel
{
    public int $id {
        get => $this->id;
    }

    public string $name {
        get => $this->name;
    }

    /**
     * @param Brand $brand
     * @return self
     */
    public static function create(Brand $brand): self
    {
        $response = new self();
        $response->id = $brand->getId();
        $response->name = $brand->getName();

        return $response;
    }
}
