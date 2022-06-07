<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Api\InventoryCatalogApi\Price;

/**
 * Bulk inventory transfer interface price plugin
 */
class BulkInventoryTransferInterface extends \Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi\BulkInventoryTransferInterface
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Transfer $transferSourceItemOptions
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Unassign $unassignSourceItemOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Transfer $transferSourceItemOptions,
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Unassign $unassignSourceItemOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
    )
    {
        parent::__construct($transferSourceItemOptions, $unassignSourceItemOptions, $optionConfig);
    }
    
}