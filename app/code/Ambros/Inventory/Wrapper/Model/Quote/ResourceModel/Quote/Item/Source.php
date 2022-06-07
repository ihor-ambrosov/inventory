<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Item;

/**
 * Quote item resource source wrapper
 */
class Source extends \Ambros\Inventory\Wrapper\Model\Framework\ResourceModel\Source
{
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param string $sourceTable
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        string $sourceTable = 'ambros_inventory__quote_item_source'
    )
    {
        parent::__construct(
            $objectReflectionFactory,
            $sourceTable
        );
    }
}