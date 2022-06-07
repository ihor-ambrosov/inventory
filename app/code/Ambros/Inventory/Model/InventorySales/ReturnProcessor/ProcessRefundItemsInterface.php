<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\ReturnProcessor;

/**
 * Process refund items Interface
 */
interface ProcessRefundItemsInterface
{
    /**
     * Execute
     * 
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Ambros\Inventory\Model\InventorySales\ReturnProcessor\Request\ItemsToRefundInterface[] $itemsToRefund
     * @param array $returnToStockItems
     * @return void
     */
    public function execute(
        \Magento\Sales\Api\Data\OrderInterface $order,
        array $itemsToRefund,
        array $returnToStockItems
    );
}