<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass;

/**
 * Assign source item tax class options resource
 */
class Assign extends \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Assign
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @param string $tableName
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType,
        string $tableName = 'ambros_inventory__inventory_source_item_tax_class'
    )
    {
        parent::__construct(
            $connectionProvider,
            $getProductTypesBySkus,
            $isSourceItemManagementAllowedForProductType,
            $tableName
        );
    }
    
}