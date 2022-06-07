<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass;

/**
 * Get source item tax class options resource
 */
class Get extends \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Get
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param string $tableName
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        string $tableName = 'ambros_inventory__inventory_source_item_tax_class'
    )
    {
        parent::__construct($connectionProvider, $tableName);
    }
    
}