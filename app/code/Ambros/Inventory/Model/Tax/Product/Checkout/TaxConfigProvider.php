<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Tax\Product\Checkout;

/**
 * Tax product checkout configuration provider
 */
class TaxConfigProvider extends \Magento\Tax\Model\TaxConfigProvider 
    implements \Magento\Checkout\Model\ConfigProviderInterface 
{
    /**
     * Get configuration
     *
     * @return array|mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig()
    {
        return [
            'isDisplayShippingPriceExclTax' => $this->isDisplayShippingPriceExclTax(),
            'isDisplayShippingBothPrices' => $this->isDisplayShippingBothPrices(),
            'reviewShippingDisplayMode' => $this->getDisplayShippingMode(),
            'reviewTotalsDisplayMode' => $this->getReviewTotalsDisplayMode(),
            'includeTaxInGrandTotal' => $this->isTaxDisplayedInGrandTotal(),
            'isFullTaxSummaryDisplayed' => $this->isFullTaxSummaryDisplayed(),
            'isZeroTaxDisplayed' => $this->taxConfig->displayCartZeroTax(),
            'defaultCountryId' => $this->getConfigValue(\Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_COUNTRY),
            'defaultRegionId' => $this->getDefaultRegionId(),
            'defaultPostcode' => $this->getConfigValue(\Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_POSTCODE),
        ];
    }

    /**
     * Get configuration value
     * 
     * @param string $path
     * @return mixed
     */
    private function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
    
    /**
     * Get default region ID
     * 
     * @return mixed
     */
    private function getDefaultRegionId()
    {
        $defaultRegionId = $this->getConfigValue(\Magento\Tax\Model\Config::CONFIG_XML_PATH_DEFAULT_REGION);
        if (0 == $defaultRegionId) {
            return null;
        }
        return $defaultRegionId;
    }
}