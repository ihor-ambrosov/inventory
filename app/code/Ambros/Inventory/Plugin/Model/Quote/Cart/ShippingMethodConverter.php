<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Cart;

/**
 * Shipping method converter plugin
 */
class ShippingMethodConverter
{
    /**
     * After model to data object
     * 
     * @param \Magento\Quote\Model\Cart\ShippingMethodConverter $subject
     * @param \Magento\Quote\Api\Data\ShippingMethodInterface $result
     * @param \Magento\Quote\Model\Quote\Address\Rate $rateModel
     * @param string $quoteCurrencyCode
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface
     */
    public function afterModelToDataObject(
        \Magento\Quote\Model\Cart\ShippingMethodConverter $subject,
        $result,
        $rateModel,
        $quoteCurrencyCode
    )
    {
        $result->getExtensionAttributes()->setSourceCode($rateModel->getSourceCode());
        return $result;
    }
}