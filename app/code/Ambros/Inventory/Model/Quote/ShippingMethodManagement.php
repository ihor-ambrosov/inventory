<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Quote;

/**
 * Shipping method management
 */
class ShippingMethodManagement implements \Ambros\Inventory\Model\Quote\ShippingMethodManagementInterface
{
    /**
     * Quote repository
     *
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private $quoteRepository;

    /**
     * Shipping method converter
     *
     * @var \Magento\Quote\Model\Cart\ShippingMethodConverter
     */
    private $shippingMethodConverter;

    /**
     * Constructor
     * 
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Quote\Model\Cart\ShippingMethodConverter $shippingMethodConverter
     * @return void
     */
    public function __construct(
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Quote\Model\Cart\ShippingMethodConverter $shippingMethodConverter
    )
    {
        $this->quoteRepository = $quoteRepository;
        $this->shippingMethodConverter = $shippingMethodConverter;
    }

    /**
     * Get multiple
     * 
     * @param integer $cartId
     * @return \Magento\Quote\Api\Data\ShippingMethodInterface[]
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function getMultiple($cartId)
    {
        $quote = $this->quoteRepository->getActive($cartId);
        $shippingAddress = $quote->getShippingAddress();
        if (!$shippingAddress->getCountryId()) {
            throw new \Magento\Framework\Exception\StateException(__('The shipping address is missing. Set the address and try again.'));
        }
        $shippingMethods = $shippingAddress->getShippingMethod();
        if (empty($shippingMethods)) {
            return [];
        }
        $shippingAddress->collectShippingRates();
        $shippingRates = $shippingAddress->getShippingRateByCode($shippingMethods);
        if (empty($shippingRates)) {
            return [];
        }
        $output = [];
        $quoteCurrencyCode = $quote->getQuoteCurrencyCode();
        foreach ($shippingRates as $shippingRate) {
            $output[] = $this->shippingMethodConverter->modelToDataObject($shippingRate, $quoteCurrencyCode);
        }
        return $output;
    }
}