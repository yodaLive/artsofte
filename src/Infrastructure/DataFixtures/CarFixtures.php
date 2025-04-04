<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\CarContext\Aggregate\Car;
use App\Domain\CarContext\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public const string CAR_REFERENCE = 'car';

    public function load(ObjectManager $manager): void
    {
        $pathToJson = __DIR__ . '/data/cars.json';
        $data = json_decode(file_get_contents($pathToJson), true);
        foreach ($data as $item) {
            $model = $this->getReference(ModelFixtures::MODEL_REFERENCE . $item['model'], Model::class);
            $brand = $model->getBrand();

            $car = new Car(
                photo: $item['photo'],
                price: $item['price'],
                model: $model,
                brand: $brand,
                id: $item['id'],
            );
            $manager->persist($car);
            $this->addReference(CarFixtures::CAR_REFERENCE . $item['id'], $car);
        }

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [
            ModelFixtures::class,
            BrandFixtures::class,
        ];
    }
}