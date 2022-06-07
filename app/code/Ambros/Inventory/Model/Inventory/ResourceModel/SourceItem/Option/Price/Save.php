<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\Price;

/**
 * Save source item price options resource
 */
class Save extends \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Save
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
        string $tableName = 'ambros_inventory__inventory_source_item_price'
    )
    {
        parent::__construct($connectionProvider, $tableName);
    }
    
}