<?php
/**
 * Copyright © 2021 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Xigen\Debugger\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const CONFIG_XML_ENABLED = 'debugger/toolbar/enabled';
    const CONFIG_XML_PARAMETER = 'debugger/toolbar/paramater';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Is enabled
     * @return bool
     */
    public function getEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_XML_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Configured parameter
     * @return mixed
     */
    public function getParameter()
    {
        return $this->scopeConfig->getValue(
            self::CONFIG_XML_PARAMETER,
            ScopeInterface::SCOPE_STORE
        );
    }
}
