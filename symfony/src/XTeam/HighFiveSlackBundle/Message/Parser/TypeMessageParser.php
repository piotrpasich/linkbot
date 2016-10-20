<?php

namespace XTeam\HighFiveSlackBundle\Message\Parser;

use XTeam\HighFiveSlackBundle\DataProvider\SlackUserProvider;
use XTeam\HighFiveSlackBundle\Entity\TypeRepository;

class TypeMessageParser implements MessageParserInterface
{

    /**
     * @var TypeRepository
     */
    private $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    public function parse($text)
    {
        $mentions = [];

        foreach ($this->typeRepository->findAll() as $type) {
            if (preg_match($type->getPattern(), $text)) {
                return $type;
            }
        }

        throw new \Exception('There is no matching type');
    }
}