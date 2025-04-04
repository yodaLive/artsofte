<?php

namespace App\Application\Repository;

use App\Domain\CarContext\Aggregate\Car;

interface CarRepositoryInterface {
    public function findAll(): array;
    public function findById(int $id): ?Car;
}


