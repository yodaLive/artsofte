<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Domain\CarContext\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const string BRAND_REFERENCE = 'brand';

    public function load(ObjectManager $manager): void
    {
        $pathToJson = __DIR__ . '/data/brands.json';
        $data = json_decode(file_get_contents($pathToJson), true);

        foreach ($data as $item) {
            $brand = new Brand($item['brand'], id: $item['id']);
            $manager->persist($brand);
            $this->addReference(self::BRAND_REFERENCE . $item['id'], $brand);
        }
        $manager->flush();
        $manager->clear();
    }
}