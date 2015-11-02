<?php

namespace TheMizzi\HelloWorld\Controller\Display;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * @package TheMizzi\HelloWorld\Controller\Index
 * @author  Joe Mizzi <jmizzi@gorillagroup.com>
 */
class Index extends Action
{
    /**
     * The PageFactory to render with.
     *
     * @var PageFactory
     */
    protected $_resultsPageFactory;

    /**
     * Set the Context and Result Page Factory from DI.
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->_resultsPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Show the Hello World Index Page.
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute() {
        return $this->_resultsPageFactory->create();
    }
}