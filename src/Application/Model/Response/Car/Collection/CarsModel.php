<?php

declare(strict_types=1);

namespace App\Application\Model\Response\Car\Collection;

use App\Application\Model\Response\Car\CarModel;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

final class CarsModel
{
    #[OA\Property(type: 'array', items: new OA\Items(ref: new Model(type: CarModel::class)))]
    public array $items {
        get => $this->items;
    }

    /**
     * @param array $cars
     * @return CarsModel
     */
    public static function create(array $cars): self
    {
        $self = new self();
        $self->items = [];
        $items = [];

        foreach ($cars as $car) {
            $items[] = CarModel::create($car);
            $self->items = $items;
        }

        return $self;
    }

    private function __construct() {}
}
