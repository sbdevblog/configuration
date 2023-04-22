<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Config\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

class SkuColumn extends Select
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * @var SearchCriteriaInterface
     */
    private SearchCriteriaInterface $searchCriteria;

    /**
     * Constructor
     *
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaInterface $searchCriteria
     * @param array $data
     */
    public function __construct(
        Context                    $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaInterface    $searchCriteria,
        array                      $data = []
    )
    {
        $this->productRepository = $productRepository;
        $this->searchCriteria = $searchCriteria;
        parent::__construct($context, $data);
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName(string $value): static
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param $value
     * @return $this
     */
    public function setInputId($value): static
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Get Product Options
     *
     * @return array
     */
    private function getSourceOptions(): array
    {
        $products = $this->productRepository->getList($this->searchCriteria)->getItems();
        $skus = [];
        if ($products) {
            foreach ($products as $product) {
                $skus[] = ["label" => $product->getName(), 'value' => $product->getSku()];
            }
        }
        return $skus;
    }
}
