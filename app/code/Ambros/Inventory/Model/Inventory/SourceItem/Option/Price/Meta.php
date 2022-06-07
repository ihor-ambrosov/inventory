<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\Price;

/**
 * Source item price option meta
 */
class Meta extends \Ambros\InventoryCommon\Model\SourceItem\Option\Meta
{
    /**
     * Constructor
     * 
     * @param string $name
     * @param string $label
     * @param string $tableName
     * @param string $backendType
     * @return void
     */
    public function __construct(
        string $name = 'price',
        string $label = 'Price',
        string $tableName = 'ambros_inventory__inventory_source_item_price',
        string $backendType = 'decimal'
    )
    {
        parent::__construct(
            $name,
            $label,
            $tableName,
            $backendType
        );
    }
}