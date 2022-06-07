<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Helper\Paypal;

/**
 * PayPal checkout helper plugin
 */
class Checkout
{
    /**
     * Session
     * 
     * @var \Ambros\Inventory\Model\Checkout\Session
     */
    private $session;

    /**
     * Quote configuration
     * 
     * @var \Ambros\Inventory\Model\Quote\Config
     */
    private $quoteConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Checkout\Session $session
     * @param \Ambros\Inventory\Model\Quote\Config $quoteConfig
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Checkout\Session $session,
        \Ambros\Inventory\Model\Quote\Config $quoteConfig
    )
    {
        $this->session = $session;
        $this->quoteConfig = $quoteConfig;
    }
    
    /**
     * Around cancel current order
     *
     * @param \Magento\Paypal\Helper\Checkout $subject
     * @param callable $proceed
     * @param string $comment
     * @return bool
     */
    public function aroundCancelCurrentOrder(
        \Magento\Paypal\Helper\Checkout $subject,
        \Closure $proceed,
        $comment
    )
    {
        if (!$this->quoteConfig->isSplitOrder()) {
            return $proceed($comment);
        }
        $canceled = false;
        $orders = $this->session->getLastRealOrders();
        if (empty($orders)) {
            return $canceled;
        }
        foreach ($orders as $order) {
            if (!$order->getId() || $order->getState() == \Magento\Sales\Model\Order::STATE_CANCELED) {
                continue;
            }
            $order->registerCancellation($comment)->save();
            $canceled = true;
        }
        return $canceled;
    }
}