<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Block\Sales\Adminhtml\Order\Create\Shipping\Method;

/**
 * Create order shipping method form plugin
 */
class Form extends \Ambros\Common\Plugin\Plugin
{
    /**
     * Stock state
     * 
     * @var \Ambros\Inventory\Api\CatalogInventory\StockStateInterface
     */
    private $stockState;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Api\CatalogInventory\StockStateInterface $stockState
    )
    {
        $this->stockState = $stockState;
    }

    /**
     * Around get active method rate
     * 
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form $subject
     * @param \Closure $proceed
     */
    public function aroundGetActiveMethodRate(
        \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form $subject,
        \Closure $proceed
    )
    {
        $groupedRates = $subject->getShippingRates();
        if (empty($groupedRates)) {
            return [];
        }
        return $subject->getCurrentShippingRate();
    }
}