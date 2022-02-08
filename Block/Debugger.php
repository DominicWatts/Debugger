<?php
/**
 * Copyright © 2021 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Xigen\Debugger\Block;

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Result\PageFactory;
use Xigen\Debugger\Helper\Config;

class Debugger extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Xigen\Debugger\Helper\Config
     */
    protected $helper;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Xigen\Debugger\Helper\Config $helper
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $helper,
        Http $request,
        PageFactory $resultPageFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->request = $request;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $data);
    }

    /**
     * Show debugger
     * @return bool
     */
    public function isDebuggerAvailable()
    {
        if (!$this->helper->getEnabled()) {
            return false;
        }
        if (!$this->request->getParam('debugger')) {
            return false;
        }
        if ($this->request->getParam('debugger') != $this->helper->getParameter()) {
            return false;
        }
        return true;
    }

    /**
     * Display route
     * @return array
     */
    public function displayRoutes()
    {
        if (!$this->isDebuggerAvailable()) {
            return [];
        }

        return [
            'Controller Module'          => $this->request->getControllerModule(),
            'Controller ClassName'       => $this->request->getControllerName(),
            'Controller ActionName'      => $this->request->getActionName(),
            'Controller Full ActionName' => $this->request->getFullActionName(),
            'Path Info'                  => $this->request->getPathInfo(),
        ];
    }

    /**
     * Display handles
     * @return array
     */
    public function displayHandles()
    {
        if (!$this->isDebuggerAvailable()) {
            return [];
        }

        $resultPage = $this->resultPageFactory->create();
        $layout = $resultPage->getLayout();
        $layoutHandles = $layout->getUpdate()->getHandles();
        return $layoutHandles;
    }
}
