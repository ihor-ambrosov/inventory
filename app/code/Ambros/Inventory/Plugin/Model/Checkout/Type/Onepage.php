<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Checkout\Type;

/**
 * Onepage checkout plugin
 */
class Onepage extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Joint data
     * 
     * @var \Ambros\Inventory\Data\JointData
     */
    private $jointData;

    /**
     * Quote configuration
     * 
     * @var \Ambros\Inventory\Model\Quote\Config
     */
    private $quoteConfig;
    
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
     * @param \Ambros\Inventory\Data\JointData $jointData
     * @param \Ambros\Inventory\Model\Quote\Config $quoteConfig
     * @param \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Inventory\Data\JointData $jointData,
        \Ambros\Inventory\Model\Quote\Config $quoteConfig,
        \Ambros\Inventory\Wrapper\Model\Quote\Quote\AddressFactory $quoteAddressWrapperFactory
    )
    {
        parent::__construct($wrapperFactory);
        $this->jointData = $jointData;
        $this->quoteConfig = $quoteConfig;
        $this->quoteAddressWrapperFactory = $quoteAddressWrapperFactory;
    }

    /**
     * Around save shipping method
     * 
     * @param \Magento\Checkout\Model\Type\Onepage $subject
     * @param \Closure $proceed
     * @param string|array $shippingMethod
     * @return array
     */
    public function aroundSaveShippingMethod(
        \Magento\Checkout\Model\Type\Onepage $subject,
        \Closure $proceed,
        $shippingMethod
    )
    {
        $this->setSubject($subject);
        $invalidResult = ['error' => -1, 'message' => __('Invalid shipping methods')];
        if (empty($shippingMethod)) {
            return $invalidResult;
        }
        if (!is_array($shippingMethod)) {
            $shippingMethods = $this->jointData->parse($shippingMethod);
        } else {
            $shippingMethods = $shippingMethod;
        }
        if (empty($shippingMethods)) {
            return $invalidResult;
        }
        $quote = $subject->getQuote();
        $shippingAddress = $quote->getShippingAddress();
        $shippingAddressWrapper = $this->quoteAddressWrapperFactory->create($shippingAddress);
        $shippingAddress->setShippingMethod($shippingMethods);
        $shippingAddressWrapper->generateShippingDescription();
        $shippingAddress->save();
        $checkout = $subject->getCheckout();
        $checkout->setStepData('shipping_method', 'complete', true);
        $checkout->setStepData('payment', 'allow', true);
        return [];
    }
    
    /**
     * Around save order
     * 
     * @param \Magento\Checkout\Model\Type\Onepage $subject
     * @param \Closure $proceed
     * @return \Magento\Checkout\Model\Type\Onepage
     */
    public function aroundSaveOrder(
        \Magento\Checkout\Model\Type\Onepage $subject,
        \Closure $proceed
    )
    {
        if (!$this->quoteConfig->isSplitOrder()) {
            return $proceed();
        }
        $this->setSubject($subject);
        $this->prepareQuote();
        $quote = $subject->getQuote();
        $orders = $this->getSubjectPropertyValue('quoteManagement')->submit($quote);
        $this->loginCustomer();
        $this->updateCheckoutSession([]);
        if (count($orders)) {
            return $subject;
        }
        $eventManager = $this->getSubjectPropertyValue('_eventManager');
        foreach ($orders as $order) {
            $eventManager->dispatch(
                'checkout_type_onepage_save_order_after',
                [
                    'order' => $order,
                    'quote' => $quote,
                ]
            );
            $this->sendOrderEmail($order);
        }
        $this->updateCheckoutSession($orders);
        foreach ($orders as $order) {
            $eventManager->dispatch(
                'checkout_submit_all_after',
                [
                    'order' => $order,
                    'quote' => $quote,
                ]
            );
        }
        return $subject;
    }

    /**
     * Prepare quote
     * 
     * @return void
     */
    private function prepareQuote(): void
    {
        $subject = $this->getSubject();
        $this->invokeSubjectMethod('validate');
        switch ($subject->getCheckoutMethod()) {
            case \Magento\Checkout\Model\Type\Onepage::METHOD_GUEST: 
                $this->invokeSubjectMethod('_prepareGuestQuote');
                break;
            case \Magento\Checkout\Model\Type\Onepage::METHOD_REGISTER: 
                $this->invokeSubjectMethod('_prepareNewCustomerQuote');
                break;
            default: 
                $this->invokeSubjectMethod('_prepareCustomerQuote');
                break;
        }
    }
    
    /**
     * Login customer
     *
     * @return void
     */
    private function loginCustomer(): void
    {
        $subject = $this->getSubject();
        if ($subject->getCheckoutMethod() !== \Magento\Checkout\Model\Type\Onepage::METHOD_REGISTER) {
            return;
        }
        try {
            $this->invokeSubjectMethod('_involveNewCustomer');
        } catch (\Exception $exception) {
            $this->getSubjectPropertyValue('_logger')->critical($exception);
        }
    }

    /**
     * Update checkout session
     * 
     * @param array $orders
     * @return void
     */
    private function updateCheckoutSession($orders): void
    {
        $subject = $this->getSubject();
        $quote = $subject->getQuote();
        $quoteId = $quote->getId();
        $checkoutSession = $this->getSubjectPropertyValue('_checkoutSession');
        $checkoutSession->setLastQuoteId($quoteId);
        $checkoutSession->setLastSuccessQuoteId($quoteId);
        $checkoutSession->clearHelperData();
        if (!count($orders)) {
            return;
        }
        $orderIds = [];
        $orderIncrementIds = [];
        $orderStatuses = [];
        foreach ($orders as $order) {
            $orderId = $order->getId();
            $orderIds[] = $orderId;
            $orderIncrementIds[$orderId] = $order->getIncrementId();
            $orderStatuses[$orderId] = $order->getStatus();
        }
        $checkoutSession->setLastOrderIds($orderIds);
        $checkoutSession->setLastRealOrderIds($orderIncrementIds);
        $checkoutSession->setLastOrderStatuses($orderStatuses);
        $lastOrder = end($orders);
        $checkoutSession->setLastOrderId($lastOrder->getId());
        $checkoutSession->setLastRealOrderId($lastOrder->getIncrementId());
        $checkoutSession->setLastOrderStatus($lastOrder->getStatus());
    }
    
    /**
     * Send order email
     * 
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @return void
     */
    private function sendOrderEmail(\Magento\Sales\Api\Data\OrderInterface $order): void
    {
        if (!$order->getCanSendNewEmailFlag()) {
            return;
        }
        try {
            $this->getSubjectPropertyValue('orderSender')->send($order);
        } catch (\Exception $exception) {
            $this->getSubjectPropertyValue('_logger')->critical($exception);
        }
    }
}