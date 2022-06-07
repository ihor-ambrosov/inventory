<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Quote\GuestCart;

/**
 * Guest shipping method management
 */
class GuestShippingMethodManagement implements \Ambros\Inventory\Model\Quote\GuestCart\GuestShippingMethodManagementInterface
{
    /**
     * Shipping method management
     * 
     * @var \Ambros\Inventory\Model\Quote\ShippingMethodManagementInterface
     */
    private $shippingMethodManagement;

    /**
     * Quote ID mask factory
     * 
     * @var \Magento\Quote\Model\QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * Constructor
     *
     * @param \Ambros\Inventory\Model\Quote\ShippingMethodManagementInterface $shippingMethodManagement
     * @param \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Quote\ShippingMethodManagementInterface $shippingMethodManagement,
        \Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
    )
    {
        $this->shippingMethodManagement = $shippingMethodManagement;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
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
        return $this->shippingMethodManagement->getMultiple(
            (int) $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId()
        );
    }
}