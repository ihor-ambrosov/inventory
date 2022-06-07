<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Block\Checkout\Onepage;

/**
 * Checkout onepage failure block wrapper
 */
class Failure extends \Ambros\Common\DataObject\Wrapper implements \Magento\Framework\View\Element\Block\ArgumentInterface
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
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param \Ambros\Inventory\Model\Quote\Config $quoteConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        \Ambros\Inventory\Model\Quote\Config $quoteConfig,
        \Magento\Checkout\Model\Session $checkoutSession
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
     * Get real order IDs
     * 
     * @return array|null
     */
    public function getRealOrderIds(): ?array
    {
        return $this->checkoutSession->getLastRealOrderIds();
    }
}