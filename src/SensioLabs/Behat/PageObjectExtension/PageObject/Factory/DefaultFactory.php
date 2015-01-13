<?php

namespace SensioLabs\Behat\PageObjectExtension\PageObject\Factory;

use Behat\Mink\Mink;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;
use SensioLabs\Behat\PageObjectExtension\PageObject\InlineElement;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory;
use SensioLabs\Behat\PageObjectExtension\PageObject\PageObject;

class DefaultFactory implements Factory
{
    /**
     * @var Mink
     */
    private $mink = null;

    /**
     * @var ClassNameResolver
     */
    private $classNameResolver;

    /**
     * @var array
     */
    private $pageParameters = array();

    /**
     * @param Mink              $mink
     * @param ClassNameResolver $classNameResolver
     * @param array             $pageParameters
     */
    public function __construct(Mink $mink, ClassNameResolver $classNameResolver, array $pageParameters)
    {
        $this->mink = $mink;
        $this->pageParameters = $pageParameters;
        $this->classNameResolver = $classNameResolver;
    }

    /**
     * @param string $name
     * @param string $session
     *
     * @return Page
     */
    public function createPage($name, $session = null)
    {
        $pageClass = $this->classNameResolver->resolvePage($name);

        return $this->instantiatePage($pageClass, $session);
    }

    /**
     * @param string $name
     * @param string $session
     *
     * @return Element
     */
    public function createElement($name, $session = null)
    {
        $elementClass = $this->classNameResolver->resolveElement($name);

        return $this->instantiateElement($elementClass, $session);
    }

    /**
     * @param array|string $selector
     * @param string $session
     *
     * @return InlineElement
     */
    public function createInlineElement($selector, $session = null)
    {
        return new InlineElement($selector, $this->mink->getSession($session), $this);
    }

    /**
     * @param string $class
     * @param string $session
     *
     * @return PageObject
     */
    public function instantiate($class, $session = null)
    {
        if (is_subclass_of($class, 'SensioLabs\Behat\PageObjectExtension\PageObject\Page')) {
            return $this->instantiatePage($class, $session);
        } elseif (is_subclass_of($class, 'SensioLabs\Behat\PageObjectExtension\PageObject\Element')) {
            return $this->instantiateElement($class, $session);
        }

        throw new \InvalidArgumentException(sprintf('Not a page object class: %s', $class));
    }

    /**
     * @param string $pageClass
     * @param string $session
     *
     * @return Page
     */
    private function instantiatePage($pageClass, $session = null)
    {
        return new $pageClass($this->mink->getSession($session), $this, $this->pageParameters);
    }

    /**
     * @param string $elementClass
     * @param string $session
     *
     * @return Element
     */
    private function instantiateElement($elementClass, $session = null)
    {
        return new $elementClass($this->mink->getSession($session), $this);
    }
}
