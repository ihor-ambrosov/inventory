<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InstantPurchase\QuoteManagement;

/**
 * Quote management shipping configuration plugin
 */
class ShippingConfiguration extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Quote address wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory
     */
    private $quoteAddressWrapperFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
    }

    /**
     * Around configure shipping method
     * 
     * @param \Magento\InstantPurchase\Model\QuoteManagement\ShippingConfiguration $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
     * @return \Magento\Quote\Model\Quote
     */
    public function aroundConfigureShippingMethod(
        \Magento\InstantPurchase\Model\QuoteManagement\ShippingConfiguration $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
    ): \Magento\Quote\Model\Quote
    {
        
        if ($quote->isVirtual()) {
            return $quote;
        }
        $shippingAddress = $quote->getShippingAddress();
        $shippingMethods = $this->getShippingMethods($shippingAddress, $shippingMethod);
        $shippingAddress->setShippingMethod($shippingMethods);
        return $quote;
    }

    /**
     * Get corresponding shipping methods
     * 
     * @param \Magento\Quote\Model\Quote\Address $address
     * @param \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getCorrespondingShippingMethods(
        \Magento\Quote\Model\Quote\Address $address,
        \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
    ): array
    {
        $address->setCollectShippingRates(true);
        $address->collectShippingRates();
        $shippingRates = $address->getAllShippingRates();
        $shippingMethods = [];
        if (!empty($shippingRates)) {
            foreach ($this->quoteAddressWrapperFactory->create($address)->getSourceCodes() as $sourceCode) {
                foreach ($shippingRates as $shippingRate) {
                    if ($shippingRate->getSourceCode() == $sourceCode) {
                        $shippingMethods[$sourceCode] = (string) $shippingRate->getCode();
                        break;
                    }
                }
                if (empty($shippingMethods[$sourceCode])) {
                    $shippingMethods = [];
                    break;
                }
            }
        }
        if (!empty($shippingMethods)) {
            return $shippingMethods;
        }
        throw new \Magento\Framework\Exception\LocalizedException(__('Specified shipping methods are not available.'));
    }
    
    /**
     * Get shipping methods
     *
     * @param \Magento\Quote\Model\Quote\Address $address
     * @param \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getShippingMethods(
        \Magento\Quote\Model\Quote\Address $address,
        \Magento\Quote\Api\Data\ShippingMethodInterface $shippingMethod
    )
    {
        if ($shippingMethod->getCarrierCode() === \Magento\InstantPurchase\Model\ShippingMethodChoose\DeferredShippingMethodChooserInterface::CARRIER) {
            return $this->invokeSubjectMethod('resolveDeferredShippingMethodChoose', $address, $shippingMethod);
        } else {
            return $this->getCorrespondingShippingMethods($address, $shippingMethod);
        }
    }
}