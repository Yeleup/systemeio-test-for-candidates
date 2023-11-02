<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tax = new Tax();
        $tax->setCountryCode('DE');
        $tax->setRate(19);
        $manager->persist($tax);

        $tax = new Tax();
        $tax->setCountryCode('IT');
        $tax->setRate(22);
        $manager->persist($tax);

        $tax = new Tax();
        $tax->setCountryCode('FR');
        $tax->setRate(20);
        $manager->persist($tax);

        $tax = new Tax();
        $tax->setCountryCode('GR');
        $tax->setRate(24);
        $manager->persist($tax);

        $manager->flush();
    }
}
