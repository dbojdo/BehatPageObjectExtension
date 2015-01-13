<?php

namespace SensioLabs\Behat\PageObjectExtension\PageObject\Factory;

use ProxyManager\Factory\AbstractLazyFactory;
use ProxyManager\Proxy\LazyLoadingInterface;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use SensioLabs\Behat\PageObjectExtension\PageObject\InlineElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\PageObject;

class LazyFactory implements Factory
{
    /**
     * @var Factory
     */
    private $decoratedFactory;

    /**
     * @var AbstractLazyFactory
     */
    private $proxyFactory;

    /**
     * @param Factory             $decoratedFactory
     * @param AbstractLazyFactory $proxyFactory
     */
    public function __construct(Factory $decoratedFactory, AbstractLazyFactory $proxyFactory)
    {
        $this->decoratedFactory = $decoratedFactory;
        $this->proxyFactory = $proxyFactory;
    }

    /**
     * @param string $name
     * @param string $session
     *
     * @return Page
     */
    public function createPage($name, $session = null)
    {
        return $this->decoratedFactory->createPage($name, $session);
    }

    /**
     * @param string $name
     * @param string $session
     *
     * @return Element
     */
    public function createElement($name, $session = null)
    {
        return $this->decoratedFactory->createElement($name, $session);
    }

    /**
     * @param string|array
     * @param string $session
     *
     * @return InlineElement
     */
    public function createInlineElement($selector, $session = null)
    {
        return $this->decoratedFactory->createInlineElement($selector, $session);
    }
    /**
     * @param string $class
     * @param string $session
     *
     * @return LazyLoadingInterface|PageObject
     */
    public function instantiate($class, $session = null)
    {
        $decoratedFactory = $this->decoratedFactory;

        $initializer = function (&$wrappedObject, LazyLoadingInterface $proxy, $method, array $parameters, &$initializer) use ($class, $decoratedFactory, $session) {
            $initializer = null;

            $wrappedObject = $decoratedFactory->instantiate($class, $session);

            return true;
        };

        return $this->proxyFactory->createProxy($class, $initializer);
    }
}
