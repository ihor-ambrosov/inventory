<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Block\Checkout\Onepage;

/**
 * Checkout onepage success block wrapper
 */
class Success extends \Ambros\Common\DataObject\Wrapper implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * Quote configuration
     * 
     * @var \Ambros\Common\DataObject\WrapperFactory
     */
    private $quoteConfig;

    /**
     * Checkout session
     * 
     * @var \Ambros\Inventory\Model\Checkout\Session
     */
    private $checkoutSession;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Inventory\Model\Quote\Config $quoteConfig
     * @param \Ambros\Inventory\Model\Checkout\Session $checkoutSession
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Inventory\Model\Quote\Config $quoteConfig,
        \Ambros\Inventory\Model\Checkout\Session $checkoutSession
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->quoteConfig = $quoteConfig;
        $this->checkoutSession = $checkoutSession;
    }

    /**
     * Check if is split order
     *
     * @return bool
     */
    public function isSplitOrder(): bool
    {
        return $this->quoteConfig->isSplitOrder();
    }

    /**
     * Get orders
     * 
     * @return array
     */
    public function getOrders(): array
    {
        return $this->checkoutSession->getLastRealOrders();
    }

    /**
     * Get order
     * 
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder(): \Magento\Sales\Api\Data\OrderInterface
    {
        return $this->checkoutSession->getLastRealOrder();
    }
    
    /**
     * Get view order URL
     * 
     * @param \Magento\Sales\Model\Order|null $order
     * @return string
     */
    public function getViewOrderUrl(\Magento\Sales\Model\Order $order = null): string
    {
        if ($order === null) {
            $order = $this->getOrder();
        }
        return $this->getObject()->getUrl(
            'sales/order/view',
            [
                'order_id' => $order->getId(),
            ]
        );
    }
    
    /**
     * Get print order URL
     * 
     * @param \Magento\Sales\Model\Order|null $order
     * @return string
     */
    public function getPrintOrderUrl(\Magento\Sales\Model\Order $order = null): string
    {
        if ($order === null) {
            $order = $this->getOrder();
        }
        return $this->getObject()->getUrl(
            'sales/order/print',
            [
                'order_id' => $order->getId(),
            ]
        );
    }

    /**
     * Get can print order
     * 
     * @param \Magento\Sales\Model\Order|null $order
     * @return bool
     */
    public function getCanPrintOrder(\Magento\Sales\Model\Order $order = null): bool
    {
        if ($order === null) {
            $order = $this->getOrder();
        }
        return $this->invokeMethod('isVisible', $order);
    }
    
    /**
     * Get can print order
     * 
     * @param \Magento\Sales\Model\Order|null $order
     * @return bool
     */
    public function getCanViewOrder(\Magento\Sales\Model\Order $order = null): bool
    {
        if ($order === null) {
            $order = $this->getOrder();
        }
        return $this->invokeMethod('canViewOrder', $order);
    }

    /**
     * Get order ID
     * 
     * @param \Magento\Sales\Model\Order|null $order
     * @return string
     */
    public function getOrderId(\Magento\Sales\Model\Order $order = null): string
    {
        if ($order === null) {
            $order = $this->getOrder();
        }
        return $order->getIncrementId();
    }
}