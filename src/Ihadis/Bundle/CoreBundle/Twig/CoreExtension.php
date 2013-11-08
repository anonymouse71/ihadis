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