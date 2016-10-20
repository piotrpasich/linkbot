<?php

namespace XTeam\HighFiveSlackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use XTeam\HighFiveSlackBundle\Entity\Type;

class LoadTypeData implements FixtureInterface
{

    private $baseData = [
        [
            'name' => '/five',
            'pattern' => '((\/five)(s){0,1})',
        ],
        [
            'name' => '/highfive',
            'pattern' => '((\/highfive)(s){0,1})',
        ],
        [
            'name' => '/fivesstorm',
            'pattern' => '((\/fivesstorm))',
        ],
    ];

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->baseData as $data) {
            $type = new Type();
            $type->setName($data['name']);
            $type->setPattern($data['pattern']);
            $manager->persist($type);
        }

        $manager->flush();
    }
}
