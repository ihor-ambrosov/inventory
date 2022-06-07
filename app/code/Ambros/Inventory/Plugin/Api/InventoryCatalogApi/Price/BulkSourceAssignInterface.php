<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Api\InventoryCatalogApi\Price;

/**
 * Bulk source assign interface price plugin
 */
class BulkSourceAssignInterface extends \Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi\BulkSourceAssignInterface
{
    
    /**
     * Construct
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Assign $assignSourceItemOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price\Assign $assignSourceItemOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Config $optionConfig
    )
    {
        parent::__construct($assignSourceItemOptions, $optionConfig);
    }
    
}