<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Sales\Order;

/**
 * Order shipping method wrapper
 */
class ShippingMethod extends \Ambros\Inventory\Wrapper\Model\Framework\SourceOption
{
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param string $attributeCode
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        string $attributeCode = 'shipping_method'
    )
    {
        parent::__construct(
            $objectReflectionFactory,
            $attributeCode
        );
    }
}