<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;

class CategoryFixtures extends AbstractBaseFixtures
{
    public function loadData(): void
    {
        $this->createMany(5, 'categories', function () {
            $category = new Category();
            $category->setName($this->faker->unique()->word);

            return $category;
        });

        $this->manager->flush();
    }
}
