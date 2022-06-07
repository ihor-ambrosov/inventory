<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Api\InventoryCatalogApi\TaxClass;

/**
 * Bulk source assign interface tax class plugin
 */
class BulkSourceAssignInterface extends \Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi\BulkSourceAssignInterface
{
    
    /**
     * Construct
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Assign $assignSourceItemOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Assign $assignSourceItemOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
    )
    {
        parent::__construct($assignSourceItemOptions, $optionConfig);
    }
    
}