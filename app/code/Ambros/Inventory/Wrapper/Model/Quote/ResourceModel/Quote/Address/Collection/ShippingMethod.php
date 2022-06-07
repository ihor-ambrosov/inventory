<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Address\Collection;

/**
 * Quote address collection shipping method wrapper
 */
class ShippingMethod extends \Ambros\Inventory\Wrapper\Model\Framework\ResourceModel\Collection\SourceOption
{
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param string $sourceOptionTable
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        string $sourceOptionTable = 'ambros_inventory__quote_address_source_shipping_method'
    )
    {
        parent::__construct(
            $objectReflectionFactory,
            $sourceOptionTable
        );
    }
}