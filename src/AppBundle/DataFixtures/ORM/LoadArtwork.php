<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Artwork;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * LoadArtwork form.
 */
class LoadArtwork extends Fixture implements DependentFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        for($i = 0; $i < 4; $i++) {
            $fixture = new Artwork();
            $fixture->setTitle('Title ' . $i);
            $fixture->setDescription('Description ' . $i);
            $fixture->setMaterials('Materials ' . $i);
            $fixture->setCopyright('Copyright ' . $i);
            $fixture->setArtworkCategory($this->getReference('artworkcategory.1'));

            $em->persist($fixture);
            $this->setReference('artwork.' . $i, $fixture);
        }

        $em->flush();

    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies() {
        // add dependencies here, or remove this
        // function and "implements DependentFixtureInterface" above
        return [
            LoadArtworkCategory::class,
        ];
    }


}
