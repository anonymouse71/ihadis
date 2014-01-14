<?php

namespace Ihadis\Bundle\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class CoreExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return array(
            'currentRoute' => $this->container->get('request')->attributes->get('_route'),
        );
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('banglaNumber', array($this, 'getBanglaNumber'))
        );
    }

    public function getBanglaNumber($val)
    {
        $engArray  = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0);
        $bangArray = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');

        $converted = str_replace($engArray, $bangArray, $val);
        return $converted;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     *
     */
    public function getName()
    {
        return 'ihadis_core_extension';
    }
}