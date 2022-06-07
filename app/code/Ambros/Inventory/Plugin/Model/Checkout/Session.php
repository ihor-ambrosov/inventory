<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\Checkout;

/**
 * Checkout session plugin
 */
class Session
{
    /**
     * Quote configuration
     * 
     * @var \Ambros\Inventory\Model\Quote\Config
     */
    private $quoteConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Quote\Config $quoteConfig
     * @retun void
     */
    public function __construct(
        \Ambros\Inventory\Model\Quote\Config $quoteConfig
    )
    {
        $this->quoteConfig = $quoteConfig;
    }
    
    /**
     * Around clear helper data
     * 
     * @param \Magento\Checkout\Model\Session $subject
     * @param \Closure $proceed
     * @return void
     */
    public function aroundClearHelperData(
        \Magento\Checkout\Model\Session $subject,
        \Closure $proceed
    )
    {
        $proceed();
        if (!$this->quoteConfig->isSplitOrder()) {
            return;
        }
        $subject
            ->setLastOrderIds(null)
            ->setLastRealOrderIds(null);
    }
}