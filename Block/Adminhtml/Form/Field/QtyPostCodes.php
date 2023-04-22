<?php
/**
 * @copyright Copyright (c) sbdevblog (http://www.sbdevblog.com)
 */

namespace SbDevBlog\Config\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\DataObject;

class QtyPostCodes extends AbstractFieldArray
{
    /**
     * @var SkuColumn
     */
    private SkuColumn $skuColumn;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('sku', ['label' => __('SKU'), 'size' => '100px', 'renderer' => $this->getSkuRenderer()]);
        $this->addColumn('qty', ['label' => __('Qty'), 'size' => '10px', 'class' => 'required-entry validate-number']);
        $this->addColumn('postcode', ['label' => __('Postcode'), 'size' => '20px', 'class' => 'required-entry']);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $sku = $row->getSku();
        if ($sku !== null) {
            $options['option_' . $this->getSkuRenderer()->calcOptionHash($sku)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * Get Sku Renderer
     *
     * @return SkuColumn
     * @throws LocalizedException
     */
    private function getSkuRenderer(): \SbDevBlog\Config\Block\Adminhtml\Form\Field\SkuColumn
    {
        $this->skuColumn = $this->getLayout()->createBlock(
            SkuColumn::class,
            '',
            ['data' => ['is_render_to_js_template' => true]]
        );
        return $this->skuColumn;
    }
}
