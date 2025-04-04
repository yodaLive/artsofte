<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\CarContext\Entity\Brand;
use App\Domain\CarContext\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture implements DependentFixtureInterface
{

    public const string MODEL_REFERENCE = 'model';

    public function load(ObjectManager $manager): void
    {
        $pathToJson = __DIR__ . '/data/models.json';
        $data = json_decode(file_get_contents($pathToJson), true);

        foreach ($data as $item) {
            $model = new Model(
                name: $item['name'],
                brand: $this->getReference(BrandFixtures::BRAND_REFERENCE . $item['brand'], Brand::class),
            );
            $this->addReference(self::MODEL_REFERENCE . $item['id'], $model);
            $manager->persist($model);
        }

        $manager->flush();
        $manager->clear();
    }


    public function getDependencies(): array
    {
        return [
            BrandFixtures::class,
        ];
    }
}