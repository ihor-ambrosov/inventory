<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Block\Multishipping\Checkout;

/**
 * Multi-shipping checkout shipping block wrapper
 */
class Shipping extends \Ambros\Common\DataObject\Wrapper implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * Current source provider
     * 
     * @var \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface
     */
    private $currentSourceProvider;

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
     * Scope configuration
     * 
     * @var \Magento\Framework\App\Config\ScopeConfigInterface 
     */
    private $scopeConfig;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider
     * @param \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\InventoryCommon\Api\CurrentSourceProviderInterface $currentSourceProvider,
        \Ambros\InventoryCommon\Model\GetSourceBySourceCode $getSourceBySourceCode,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->currentSourceProvider = $currentSourceProvider;
        $this->getSourceBySourceCode = $getSourceBySourceCode;
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
        $this->scopeConfig = $scopeConfig;
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
     * Get source carrier name
     * 
     * @param string $sourceCode
     * @param string $carrierCode
     * @return string
     */
    public function getSourceCarrierName(string $sourceCode, string $carrierCode): string
    {
        $originSourceCode = $this->currentSourceProvider->getSourceCode();
        $this->currentSourceProvider->setSourceCode($sourceCode);
        $this->scopeConfig->setSourceCode($sourceCode);
        $carrierTitle = $this->scopeConfig->getValue('carriers/'.$carrierCode.'/title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $this->scopeConfig->setSourceCode($originSourceCode);
        if ($carrierTitle) {
            return $carrierTitle;
        }
        return $carrierCode;
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
     * Get shipping method
     * 
     * @param \Magento\Quote\Api\Data\AddressInterface $quoteAddress
     * @param string $sourceCode
     * @return string|null
     */
    public function getShippingMethod(
        \Magento\Quote\Api\Data\AddressInterface $quoteAddress,
        string $sourceCode
    ): ?string
    {
        return $this->quoteAddressWrapperFactory->create($quoteAddress)->getShippingMethod($sourceCode);
    }
}