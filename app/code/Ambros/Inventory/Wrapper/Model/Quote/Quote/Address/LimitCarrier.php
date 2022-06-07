<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\Quote\Address;

/**
 * Quote address limit carrier wrapper
 */
class LimitCarrier extends \Ambros\Inventory\Wrapper\Model\Framework\SourceOption
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
        string $attributeCode = 'limit_carrier'
    )
    {
        parent::__construct(
            $objectReflectionFactory,
            $attributeCode
        );
    }
}