<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Api\InventoryApi\TaxClass;

/**
 * Source items delete interface tax class plugin
 */
class SourceItemsDeleteInterface extends \Ambros\InventoryCommon\Plugin\Api\InventoryApi\SourceItemsDeleteInterface
{
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Delete $deleteOptions
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\ResourceModel\SourceItem\Option\TaxClass\Delete $deleteOptions,
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Config $optionConfig
    )
    {
        parent::__construct($deleteOptions, $optionConfig);
    }

}