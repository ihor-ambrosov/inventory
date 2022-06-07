<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InstantPurchase\ShippingMethodChoose;

/**
 * Cheapest method deferred shipping method chooser plugin
 */
class CheapestMethodDeferredChooser
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
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
    )
    {
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
    }
    
    /**
     * Around choose
     * 
     * @param \Magento\InstantPurchase\Model\ShippingMethodChoose\CheapestMethodDeferredChooser $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Model\Quote\Address $address
     * @return array
     */
    public function aroundChoose(
        \Magento\InstantPurchase\Model\ShippingMethodChoose\CheapestMethodDeferredChooser $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Address $address
    )
    {
        $address->setCollectShippingRates(true);
        $address->collectShippingRates();
        $shippingRates = $this->getCheapestShippingRates($address);
        $shippingMethods = [];
        foreach ($shippingRates as $sourceCode => $shippingRate) {
            $shippingMethods[$sourceCode] = $shippingRate->getCode();
        }
        return $shippingMethods;
    }
    
    /**
     * Get cheapest shipping rates
     * 
     * @param \Magento\Quote\Model\Quote\Address $address
     * @return \Magento\Quote\Model\Quote\Address\Rate[]
     */
    protected function getCheapestShippingRates(\Magento\Quote\Model\Quote\Address $address): array
    {
        $cheapestShippingRates = [];
        $shippingRates = $address->getAllShippingRates();
        if (empty($shippingRates)) {
            return $cheapestShippingRates;
        }
        foreach ($this->quoteAddressWrapperFactory->create($address)->getSourceCodes() as $sourceCode) {
            foreach ($shippingRates as $shippingRate) {
                if ($shippingRate->getSourceCode() != $sourceCode) {
                    continue;
                }
                if (empty($cheapestShippingRates[$sourceCode])) {
                    $cheapestShippingRates[$sourceCode] = $shippingRate;
                    continue;
                }
                if ($shippingRate->getPrice() < $cheapestShippingRates[$sourceCode]->getPrice()) {
                    $cheapestShippingRates[$sourceCode] = $shippingRate;
                }
            }
            if (empty($cheapestShippingRates[$sourceCode])) {
                $cheapestShippingRates = [];
                break;
            }
        }
        return $cheapestShippingRates;
    }
}