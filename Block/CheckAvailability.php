<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Config\Block;

use Magento\Framework\View\Element\Template;
use SbDevBlog\Config\Services\GetStoreConfigurationService;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\Json\Helper\Data;

class CheckAvailability extends Template
{
    /**
     * @var GetStoreConfigurationService
     */
    private GetStoreConfigurationService $configurationService;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var CatalogHelper
     */
    private CatalogHelper $catalogHelper;

    /**
     * Constructor
     *
     * @param Template\Context $context
     * @param GetStoreConfigurationService $configurationService
     * @param Json $json
     * @param CatalogHelper $catalogHelper
     * @param array $data
     */
    public function __construct(
        Template\Context             $context,
        GetStoreConfigurationService $configurationService,
        Json                         $json,
        CatalogHelper                $catalogHelper,
        array                        $data = []
    )
    {
        $this->configurationService = $configurationService;
        $this->json = $json;
        $this->catalogHelper = $catalogHelper;
        parent::__construct($context, $data);
    }

    /**
     * Get check availability config
     *
     * @return mixed
     */

    public function getCheckAvailability(): mixed
    {
        $config = $this->configurationService->getCheckAvailabilityConfig();
        if (!empty($config) && is_array($config)) {
            return $this->encodeData($config);
        }
        if($this->decodeData($config)){
            return $config;
        }
        return $this->encodeData([]);
    }

    /**
     * Encode Params
     *
     * @param array $params
     * @return bool|string
     */
    private function encodeData(array $params = []): bool|string
    {
        return $this->json->serialize($params);
    }

    /**
     * Get Current SKU
     *
     * @return string
     */
    public function getCurrentSku(): string
    {
        return $this->catalogHelper->getProduct()->getSku();
    }

    /**
     * Validate String
     *
     * @param string $params
     * @return bool
     */
    private function decodeData(string $params): bool
    {
        try {
            $this->json->unserialize($params);
            return true;
        } catch (\InvalidArgumentException $exception){
        }
        return false;
    }

}
