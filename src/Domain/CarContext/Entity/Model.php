<?php

declare(strict_types=1);

namespace App\Domain\CarContext\Entity;

use App\Domain\CarContext\Aggregate\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'models')]
class Model
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', nullable: false)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'models')]
    #[ORM\JoinColumn(name: 'brand_id', referencedColumnName: 'id', nullable: false)]
    private Brand $brand;

    /** @var Collection<int, Model> */
    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'model')]
    private Collection $cars;

    public function __construct(
        string $name,
        Brand $brand,
    ) {
        $this->name = $name;
        $this->brand = $brand;
        $this->cars = new ArrayCollection();
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

}