<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Catalog\Product\SourceQuote;

/**
 * Product source quote shipping rates converter
 */
class ShippingRatesConverter
{
    /**
     * Converter
     * 
     * @var \Magento\Quote\Model\Cart\ShippingMethodConverter
     */
    private $converter;

    /**
     * Constructor
     * 
     * @param \Magento\Quote\Model\Cart\ShippingMethodConverter $converter
     * @return void
     */
    public function __construct(\Magento\Quote\Model\Cart\ShippingMethodConverter $converter)
    {
        $this->converter = $converter;
    }
    
    /**
     * Process
     * 
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[]
     */
    public function process(\Magento\Quote\Api\Data\CartInterface $quote): array
    {
        $shippingRates = [];
        if ($quote->isVirtual()) {
            return $shippingRates;
        }
        $groupedShippingRates = $quote->getShippingAddress()->getGroupedAllShippingRates();
        if (empty($groupedShippingRates)) {
            return $shippingRates;
        }
        $quoteCurrencyCode = $quote->getQuoteCurrencyCode();
        foreach ($groupedShippingRates as $sourceShippingRates) {
            foreach ($sourceShippingRates as $carrierShippingRates) {
                foreach ($carrierShippingRates as $shippingRate) {
                    $shippingRates[] = $this->converter->modelToDataObject($shippingRate, $quoteCurrencyCode);
                }
            }
        }
        return $shippingRates;
    }
}