<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $coupon = new Coupon();
        $coupon->setCode('D10');
        $coupon->setType('fix');
        $coupon->setValue(10);
        $manager->persist($coupon);

        $coupon = new Coupon();
        $coupon->setCode('D15');
        $coupon->setType('percent');
        $coupon->setValue(15);
        $manager->persist($coupon);

        $manager->flush();
    }
}
