<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Config\Services;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class GetStoreConfigurationService
{
    private const POSTCODE_QTY_PATH_XML = "sbdevblog/qty_postcodes/availability";
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get Postcode-qty against products
     *
     * @return mixed
     */
    public function getCheckAvailabilityConfig()
    {
        return $this->getConfig(self::POSTCODE_QTY_PATH_XML);
    }

    /**
     * Get Configuration Values
     *
     * @param string $path
     * @return mixed
     */
    private function getConfig(string $path): mixed
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }
}
