<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Inventory\ResourceModel\SourceItem\Collection\Option;

/**
 * Source item collection price option plugin
 */
class Price extends \Ambros\InventoryCommon\Plugin\Model\Inventory\ResourceModel\SourceItem\Collection\Option
{
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\SourceItem\Option\Price\Meta $optionMeta
    )
    {
        parent::__construct($optionMeta);
    }
}