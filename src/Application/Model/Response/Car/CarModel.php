<?php

declare(strict_types=1);

namespace App\Application\Model\Response\Car;

namespace App\Application\Model\Response\Car;

use App\Application\Model\Response\Brand\BrandModel;
use App\Application\Model\Response\ModelCar\ModelCarModel;
use App\Domain\CarContext\Aggregate\Car;

final class CarModel
{
    public int $id {
        get => $this->id;
    }

    public float $price {
        get => $this->price;
    }

    public string $photo {
        get => $this->photo;
    }

    public BrandModel $brand {
        get => $this->brand;
    }

    public ModelCarModel $model {
        get => $this->model;
    }

    /**
     * @param Car $car
     * @return self
     */
    public static function create(Car $car): self
    {
        $response = new self();
        $response->id = $car->getId();
        $response->price = $car->getPrice();
        $response->photo = $car->getPhoto();
        $response->brand = BrandModel::create($car->getBrand());
        $response->model = ModelCarModel::create($car->getModel());

        return $response;
    }
}
