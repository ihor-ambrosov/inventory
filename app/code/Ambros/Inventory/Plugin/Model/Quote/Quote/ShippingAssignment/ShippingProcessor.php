<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Quote\Quote\ShippingAssignment;

/**
 * Quote shipping assignment shipping processor plugin
 */
class ShippingProcessor
{
    /**
     * Joint data
     * 
     * @var \Ambros\Inventory\Data\JointData
     */
    private $jointData;

    /**
     * Shipping method full code
     * 
     * @var \Ambros\Inventory\Data\Quote\ShippingMethodFullCode
     */
    private $shippingMethodFullCode;

    /**
     * Shipping method management
     * 
     * @var \Magento\Quote\Model\ShippingMethodManagement
     */
    private $shippingMethodManagement;

    /**
     * Shipping address management
     * 
     * @var \Magento\Quote\Model\ShippingAddressManagement
     */
    private $shippingAddressManagement;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Data\JointData $jointData
     * @param \Ambros\Inventory\Data\Quote\ShippingMethodFullCode $shippingMethodFullCode
     * @param \Magento\Quote\Model\ShippingMethodManagement $shippingMethodManagement
     * @param \Magento\Quote\Model\ShippingAddressManagement $shippingAddressManagement
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Data\JointData $jointData,
        \Ambros\Inventory\Data\Quote\ShippingMethodFullCode $shippingMethodFullCode,
        \Magento\Quote\Model\ShippingMethodManagement $shippingMethodManagement,
        \Magento\Quote\Model\ShippingAddressManagement $shippingAddressManagement
    )
    {
        $this->jointData = $jointData;
        $this->shippingMethodFullCode = $shippingMethodFullCode;
        $this->shippingMethodManagement = $shippingMethodManagement;
        $this->shippingAddressManagement = $shippingAddressManagement;
    }
    
    /**
     * Around save
     * 
     * @param \Magento\Quote\Model\Quote\ShippingAssignment\ShippingProcessor $subject
     * @param \Closure $proceed
     * @param \Magento\Quote\Api\Data\ShippingInterface $shipping
     * @param \Magento\Quote\Api\Data\CartInterface $quote
     * @return void
     */
    public function aroundSave(
        \Magento\Quote\Model\Quote\ShippingAssignment\ShippingProcessor $subject,
        \Closure $proceed,
        \Magento\Quote\Api\Data\ShippingInterface $shipping,
        \Magento\Quote\Api\Data\CartInterface $quote
    )
    {
        $shippingAddress = $shipping->getAddress();
        $this->shippingAddressManagement->assign($quote->getId(), $shippingAddress);
        $shippingMethods = $shipping->getMethod();
        if (empty($shippingMethods) || $quote->getItemsCount() <= 0) {
            return $this;
        }
        $shippingCarrierCodes = [];
        $shippingMethodCodes = [];
        foreach ($shippingMethods as $sourceCode => $shippingMethod) {
            list($shippingCarrierCode, $shippingMethodCode) = $this->shippingMethodFullCode->parse($shippingMethod);
            $shippingCarrierCodes[$sourceCode] = $shippingCarrierCode;
            $shippingMethodCodes[$sourceCode] = $shippingMethodCode;
        }
        $this->shippingMethodManagement->apply(
            $quote->getId(), 
            $this->jointData->generate($shippingCarrierCodes), 
            $this->jointData->generate($shippingMethodCodes)
        );
    }
}