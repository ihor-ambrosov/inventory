<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\Price;

/**
 * Source item price options processor
 */
class Processor extends \Ambros\InventoryCommon\Model\SourceItem\Option\Processor
{
    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Save $saveOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Delete $deleteOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Save $saveOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Delete $deleteOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    )
    {
        parent::__construct($optionFactory, $saveOptions, $deleteOptions, $optionMeta, $dataObjectHelper);
    }
}