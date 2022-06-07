<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass;

/**
 * Get source item tax class options
 */
class Get extends \Ambros\InventoryCommon\Model\SourceItem\Option\Get 
    implements \Ambros\Inventory\Api\Inventory\SourceItem\Option\TaxClass\GetInterface 
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Get $resource
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Get $resource,
        \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterfaceFactory $optionFactory,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    )
    {
        parent::__construct($resource, $optionFactory, $optionMeta, $dataObjectHelper);
    }
}