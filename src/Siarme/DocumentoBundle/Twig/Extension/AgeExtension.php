<?php

namespace Siarme\DocumentoBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;
use \DateTime;
use \Twig_Extension;
use \Twig_SimpleFilter;

/**
 * Class AgeExtension
 * @package DocumentoBundle\Twig
 */
class AgeExtension extends Twig_Extension
{
    /**
     * @param DateTime $dateTime
     * @return int
     */
    public function age(DateTime $dateTime)
    {
        return $dateTime->diff(new DateTime())->format('%Y');
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('age', [$this, 'age']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DocumentoBundle\age';
    }
}