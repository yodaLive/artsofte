<?php

declare(strict_types=1);

namespace App\Domain\CarContext\Aggregate;

use App\Domain\CarContext\Entity\Brand;
use App\Domain\CarContext\Entity\Model;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cars')]
class Car
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'photo', type: 'string', nullable: false)]
    private string $photo;

    #[ORM\Column(name: 'price', type: 'decimal', precision: 10, scale: 2, nullable: false)]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Model::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(name: 'model_id', referencedColumnName: 'id', nullable: false)]
    private Model $model;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    public function __construct(
        string $photo,
        float $price,
        Model $model,
        Brand $brand,
        ?int $id = null,
    ) {
        $this->id = $id;
        $this->photo = $photo;
        $this->price = $price;
        $this->model = $model;
        $this->brand = $brand;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getId(): int
    {
        return $this->id;
    }
}