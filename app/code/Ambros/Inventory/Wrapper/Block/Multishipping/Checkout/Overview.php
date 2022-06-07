<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Block\Multishipping\Checkout;

/**
 * Multi-shipping checkout overview block wrapper
 */
class Overview extends \Ambros\Common\DataObject\Wrapper implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * Get source by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetSourceBySourceCode
     */
    private $getSourceBySourceCode;
    
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
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->getSourceBySourceCode = $getSourceBySourceCode;
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
    }
    
    /**
     * Get source code
     * 
     * @param string $sourceCode
     * @return string
     */
    public function getSourceName(string $sourceCode): string
    {
        $source = $this->getSourceBySourceCode->execute($sourceCode);
        return $source ? $source->getName() : $sourceCode;
    }
    
    /**
     * Get source codes
     * 
     * @param \Magento\Quote\Api\Data\AddressInterface $quoteAddress
     * @return array
     */
    public function getSourceCodes(\Magento\Quote\Api\Data\AddressInterface $quoteAddress): array
    {
        return $this->quoteAddressWrapperFactory->create($quoteAddress)->getSourceCodes();
    }
    
    /**
     * Get current shipping rates
     * 
     * @param \Magento\Quote\Api\Data\AddressInterface $quoteAddress
     * @return \Magento\Quote\Model\Quote\Address\Rate[]
     */
    public function getCurrentShippingRates(\Magento\Quote\Api\Data\AddressInterface $quoteAddress): array
    {
        return $this->quoteAddressWrapperFactory->create($quoteAddress)->getCurrentShippingRates();
    }
}