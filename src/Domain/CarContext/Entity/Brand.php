<?php

declare(strict_types=1);

namespace App\Domain\CarContext\Entity;

use App\Domain\CarContext\Aggregate\Car;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'brands')]
class Brand
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', nullable: false)]
    private string $name;

    /** @var Collection<int, Model> */
    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: 'brand')]
    private Collection $models;

    /** @var Collection<int, Car> */
    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'model')]
    private Collection $cars;

    public function __construct(
        string $name,
        ?int $id = null,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->cars = new ArrayCollection();
        $this->models = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModels(): Collection
    {
        return $this->models;
    }

    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function getId(): int
    {
        return $this->id;
    }

}