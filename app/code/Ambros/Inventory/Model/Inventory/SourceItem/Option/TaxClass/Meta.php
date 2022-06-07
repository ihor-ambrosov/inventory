<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass;

/**
 * Source item tax class option meta
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
     * @param string $frontendInput
     * @param string $sourceModel
     * @return void
     */
    public function __construct(
        string $name = 'tax_class',
        string $label = 'Tax Class',
        string $tableName = 'ambros_inventory__inventory_source_item_tax_class',
        string $backendType = 'int',
        string $frontendInput = 'select',
        string $sourceModel = \Magento\Tax\Model\TaxClass\Source\Product::class
    )
    {
        parent::__construct(
            $name,
            $label,
            $tableName,
            $backendType,
            $frontendInput,
            $sourceModel
        );
    }
}