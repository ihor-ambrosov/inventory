<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\IsProductSalableForRequestedQtyCondition;

/**
 * Back order notify customer condition
 */
class BackOrderNotifyCustomerCondition extends \Ambros\Inventory\Model\InventorySales\IsProductSalableForRequestedQtyCondition\AbstractCondition
{
    /**
     * Get source items
     * 
     * @var \Ambros\Inventory\Model\InventorySales\GetSourceItems
     */
    private $getSourceItems;
    
    /**
     * Get stock item configuration
     * 
     * @var \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration
     */
    private $getStockItemConfiguration;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems
     * @param \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode
     * @param \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems,
        \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode,
        \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration,
        \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory,
        \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory
    )
    {
        parent::__construct(
            $getStockIdBySourceCode,
            $productSalabilityErrorFactory,
            $productSalableResultFactory
        );
        $this->getSourceItems = $getSourceItems;
        $this->getStockItemConfiguration = $getStockItemConfiguration;
    }

    /**
     * Execute
     * 
     * @param string $sku
     * @param string $sourceCode
     * @param float $requestedQty
     * @return \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(string $sku, string $sourceCode, float $requestedQty): \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface
    {
        $stockId = $this->getStockIdBySourceCode->execute($sourceCode);
        $stockItemConfiguration = $this->getStockItemConfiguration->execute($sku, $sourceCode);
        if (
            $stockItemConfiguration->isManageStock() && 
            $stockItemConfiguration->getBackorders() === \Magento\InventoryConfigurationApi\Api\Data\StockItemConfigurationInterface::BACKORDERS_YES_NOTIFY
        ) {
            $sourceItem = $this->getSourceItems->execute($sku, $stockId)[$sourceCode] ?? null;
            if (!$sourceItem) {
                return $this->createProductSalableResult([]);
            }
            $salableQty = $sourceItem->getQuantity();
            $backOrderQty = $requestedQty - $salableQty;
            $displayQty = $this->getDisplayQty($backOrderQty, $salableQty, $requestedQty);
            if ($displayQty > 0) {
                return $this->createProductSalableResult([$this->createProductSalabilityError(
                    'back_order-not-enough',
                    __('We don\'t have as many quantity as you requested, but we\'ll back order the remaining %1.', $displayQty * 1)
                )]);
            }
        }
        return $this->createProductSalableResult([]);
    }
    
    /**
     * Get display qty
     *
     * @param float $backOrderQty
     * @param float $salableQty
     * @param float $requestedQty
     * @return float
     */
    private function getDisplayQty(float $backOrderQty, float $salableQty, float $requestedQty): float
    {
        if ($backOrderQty > 0 && $salableQty > 0) {
            return $backOrderQty;
        } elseif ($requestedQty > $salableQty) {
            return $requestedQty;
        }
        return 0;
    }
}