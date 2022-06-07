<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Inventory\ResourceModel\SourceItem\Collection\Option;

/**
 * Source item collection tax class option plugin
 */
class TaxClass extends \Ambros\InventoryCommon\Plugin\Model\Inventory\ResourceModel\SourceItem\Collection\Option
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\TaxClass\Meta $optionMeta
    )
    {
        parent::__construct($optionMeta);
    }
}