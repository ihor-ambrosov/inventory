<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\ReturnProcessor;

/**
 * Get invoiced items per source
 */
class GetInvoicedItemsPerSource implements \Magento\InventorySalesApi\Model\ReturnProcessor\GetSourceDeductedOrderItemsInterface
{
    /**
     * Order item wrapper factory
     * 
     * @var \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory 
     */
    private $orderItemWrapperFactory;

    /**
     * Get SKU from order item
     * 
     * @var \Magento\InventorySalesApi\Model\GetSkuFromOrderItemInterface
     */
    private $getSkuFromOrderItem;

    /**
     * Source deducted order item factory
     * 
     * @var \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemFactory
     */
    private $sourceDeductedOrderItemFactory;

    /**
     * Source deducted order items result factory
     * 
     * @var \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemsResultFactory
     */
    private $sourceDeductedOrderItemsResultFactory;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory $orderItemWrapperFactory
     * @param \Magento\InventorySalesApi\Model\GetSkuFromOrderItemInterface $getSkuFromOrderItem
     * @param \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemFactory $sourceDeductedOrderItemFactory
     * @param \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemsResultFactory $sourceDeductedOrderItemsResultFactory
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Wrapper\Model\Sales\Order\ItemFactory $orderItemWrapperFactory,
        \Magento\InventorySalesApi\Model\GetSkuFromOrderItemInterface $getSkuFromOrderItem,
        \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemFactory $sourceDeductedOrderItemFactory,
        \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemsResultFactory $sourceDeductedOrderItemsResultFactory
    )
    {
        $this->orderItemWrapperFactory = $orderItemWrapperFactory;
        $this->getSkuFromOrderItem = $getSkuFromOrderItem;
        $this->sourceDeductedOrderItemFactory = $sourceDeductedOrderItemFactory;
        $this->sourceDeductedOrderItemsResultFactory = $sourceDeductedOrderItemsResultFactory;
    }

    /**
     * Execute
     * 
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param array $returnToStockItems
     * @return \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemsResult[]
     */
    public function execute(\Magento\Sales\Api\Data\OrderInterface $order, array $returnToStockItems): array
    {
        $qtys = [];
        foreach ($order->getInvoiceCollection() as $invoice) {
            foreach ($invoice->getItems() as $item) {
                $orderItem = $item->getOrderItem();
                if ($this->isValidItem($orderItem, $returnToStockItems)) {
                    $sourceCode = (string) $this->orderItemWrapperFactory->create($orderItem)->getSourceCode();
                    $sku = $this->getSkuFromOrderItem->execute($orderItem);
                    $qtys[$sourceCode][$sku] = ($qtys[$sourceCode][$sku] ?? 0) + $item->getQty();
                }
            }
        }
        return $this->getSourceDeductedOrderItemsResults($qtys);
    }

    /**
     * Check if is valid item
     * 
     * @param \Magento\Sales\Model\Order\Item $orderItem
     * @param array $returnToStockItems
     * @return bool
     */
    private function isValidItem(\Magento\Sales\Model\Order\Item $orderItem, array $returnToStockItems): bool
    {
        return (
            in_array($orderItem->getId(), $returnToStockItems) || 
            in_array($orderItem->getParentItemId(), $returnToStockItems)
        ) && $orderItem->getIsVirtual() && !$orderItem->isDummy();
    }
    
    /**
     * Get source deducted order items results
     * 
     * @param array $qtys
     * @return \Magento\InventorySalesApi\Model\ReturnProcessor\Result\SourceDeductedOrderItemsResult[]
     */
    private function getSourceDeductedOrderItemsResults(array $qtys): array
    {
        $results = [];
        foreach ($qtys as $sourceCode => $sourceQtys) {
            $items = [];
            foreach ($sourceQtys as $sku => $qty) {
                $items[] = $this->sourceDeductedOrderItemFactory->create([
                    'sku' => $sku,
                    'quantity' => $qty,
                ]);
            }
            $results[] = $this->sourceDeductedOrderItemsResultFactory->create([
                'sourceCode' => (string) $sourceCode,
                'items' => $items,
            ]);
        }
        return $results;
    }
}