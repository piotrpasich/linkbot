<?php

namespace AppBundle\Twig;

class htmlEntityDecodeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('html_entity_decode', array($this, 'htmlEntityDecode'))
        );
    }

    public function htmlEntityDecode($html)
    {
        $html = urldecode($html);
        return $html;
    }

    public function getName()
    {
        return 'html_entity_decode_extension';
    }
}