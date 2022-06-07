<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Address;

/**
 * Quote address collection wrapper
 */
class Collection extends \Ambros\Common\DataObject\Wrapper
{
    /**
     * Wrapper factory
     * 
     * @var \Ambros\Common\DataObject\WrapperFactory
     */
    private $wrapperFactory;

    /**
     * Quote address wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory
     */
    private $quoteAddressWrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->wrapperFactory = $wrapperFactory;
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
    }

    /**
     * After load with filter
     *
     * @return void
     */
    public function afterLoadWithFilter(): void
    {
        $collection = $this->getObject();
        $quoteAddressIds = [];
        foreach ($collection->getItems() as $quoteAddress) {
            $quoteAddressIds[] = $quoteAddress->getId();
        }
        $shippingMethodWrapper = $this->wrapperFactory->create(
            $this->getObject(),
            \Ambros\Inventory\Wrapper\Model\Quote\ResourceModel\Quote\Address\Collection\ShippingMethod::class
        );
        $sourceOptions = $shippingMethodWrapper->getSourceOptions($quoteAddressIds);
        foreach ($collection->getItems() as $quoteAddress) {
            $quoteAddressId = $quoteAddress->getId();
            $this->quoteAddressWrapperFactory->create($quoteAddress)->setShippingMethods($sourceOptions[$quoteAddressId] ?? []);
        }
    }
}