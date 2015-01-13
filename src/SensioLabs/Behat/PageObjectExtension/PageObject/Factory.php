<?php

namespace SensioLabs\Behat\PageObjectExtension\PageObject;

interface Factory
{
    /**
     * @param string $name
     * @param string $session
     *
     * @return Page
     */
    public function createPage($name, $session = null);

    /**
     * @param string $name
     * @param string $session
     *
     * @return Element
     */
    public function createElement($name, $session = null);

    /**
     * @param string|array
     * @param string $session
     *
     * @return InlineElement
     */
    public function createInlineElement($selector, $session = null);

    /**
     * @param string $class
     * @param string $session
     *
     * @return PageObject
     */
    public function instantiate($class, $session = null);
}
