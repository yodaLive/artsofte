<?php

declare(strict_types=1);

namespace App\Application\Model\Response\Brand;

namespace App\Application\Model\Response\ModelCar;

use App\Domain\CarContext\Entity\Model;

final class ModelCarModel
{
    public int $id {
        get => $this->id;
    }

    public string $name {
        get => $this->name;
    }

    /**
     * @param Model $model
     * @return self
     */
    public static function create(Model $model): self
    {
        $response = new self();
        $response->id = $model->getId();
        $response->name = $model->getName();

        return $response;
    }
}
