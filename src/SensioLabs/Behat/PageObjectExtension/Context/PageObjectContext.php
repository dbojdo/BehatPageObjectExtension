<?php

namespace SensioLabs\Behat\PageObjectExtension\Context;

use Behat\Behat\Context\Context;
use SensioLabs\Behat\PageObjectExtension\PageObject\Factory as PageObjectFactory;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use SensioLabs\Behat\PageObjectExtension\PageObject\Element;

class PageObjectContext implements Context, PageObjectAware
{
    /**
     * @var PageObjectFactory
     */
    private $pageObjectFactory = null;

    /**
     * @param string $name
     * @param string $session
     *
     * @return Page
     *
     * @throws \RuntimeException
     */
    public function getPage($name, $session = null)
    {
        if (null === $this->pageObjectFactory) {
            throw new \RuntimeException('To create pages you need to pass a factory with setPageObjectFactory()');
        }

        return $this->pageObjectFactory->createPage($name, $session);
    }

    /**
     * @param string $name
     * @param string $session
     *
     * @return Element
     *
     * @throws \RuntimeException
     */
    public function getElement($name, $session = null)
    {
        if (null === $this->pageObjectFactory) {
            throw new \RuntimeException('To create elements you need to pass a factory with setPageObjectFactory()');
        }

        return $this->pageObjectFactory->createElement($name, $session);
    }

    /**
     * @param PageObjectFactory $pageObjectFactory
     */
    public function setPageObjectFactory(PageObjectFactory $pageObjectFactory)
    {
        $this->pageObjectFactory = $pageObjectFactory;
    }

    /**
     * @return PageObjectFactory
     */
    public function getPageObjectFactory()
    {
        if (null === $this->pageObjectFactory) {
            throw new \RuntimeException('To access the page factory you need to pass it first with setPageObjectFactory()');
        }

        return $this->pageObjectFactory;
    }
}
