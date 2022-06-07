<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales\IsProductSalableForRequestedQtyCondition;

/**
 * Is salable with reservations condition
 */
class IsSalableWithReservationsCondition extends \Ambros\Inventory\Model\InventorySales\IsProductSalableForRequestedQtyCondition\AbstractCondition
{
    /**
     * Get reservations quantity
     * 
     * @var \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface
     */
    private $getReservationsQuantity;

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
     * @param \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode
     * @param \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface $getReservationsQuantity
     * @param \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems
     * @param \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalabilityErrorInterfaceFactory $productSalabilityErrorFactory
     * @param \Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory $productSalableResultFactory
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode,
        \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface $getReservationsQuantity,
        \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems,
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
        $this->getReservationsQuantity = $getReservationsQuantity;
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
        $sourceItem = $this->getSourceItems->execute($sku, $stockId)[$sourceCode] ?? null;
        if (!$sourceItem) {
            return $this->createProductSalableResult([$this->createProductSalabilityError(
                'is_salable_with_reservations-no_data',
                __('The requested sku is not assigned to given stock')
            )]);
        }
        $stockItemConfiguration = $this->getStockItemConfiguration->execute($sku, $sourceCode);
        $reservationQty = $this->getReservationsQuantity->execute($sku, $sourceCode);
        $qty = $sourceItem->getQuantity();
        $isSalable = $sourceItem->isSalable();
        $qtyWithReservation = $qty + $reservationQty;
        $qtyLeftInStock = $qtyWithReservation - $stockItemConfiguration->getMinQty();
        $isInStock = bccomp((string) $qtyLeftInStock, (string) $requestedQty, 4) >= 0;
        $isEnoughQty = $isSalable && $isInStock;
        if (!$isEnoughQty) {
            return $this->createProductSalableResult([$this->createProductSalabilityError(
                'is_salable_with_reservations-not_enough_qty',
                __('The requested qty is not available')
            )]);
        }
        return $this->createProductSalableResult([]);
    }
}