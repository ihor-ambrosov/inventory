<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales;

/**
 * Get product salable qty model
 */
class GetProductSalableQty implements \Ambros\Inventory\Api\InventorySales\GetProductSalableQtyInterface
{
    /**
     * Get stock ID by source code
     * 
     * @var \Ambros\InventoryCommon\Model\GetStockIdBySourceCode 
     */
    private $getStockIdBySourceCode;

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
     * Get product types by SKUs
     * 
     * @var \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface
     */
    private $getProductTypesBySkus;

    /**
     * Is source item management allowed for product type
     * 
     * @var \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface 
     */
    private $isSourceItemManagementAllowedForProductType;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode
     * @param \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface $getReservationsQuantity
     * @param \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems
     * @param \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
     * @param \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus
     * @param \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\GetStockIdBySourceCode $getStockIdBySourceCode,
        \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface $getReservationsQuantity,
        \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems,
        \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration,
        \Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface $getProductTypesBySkus,
        \Magento\InventoryConfigurationApi\Model\IsSourceItemManagementAllowedForProductTypeInterface $isSourceItemManagementAllowedForProductType
    )
    {
        $this->getStockIdBySourceCode = $getStockIdBySourceCode;
        $this->getReservationsQuantity = $getReservationsQuantity;
        $this->getSourceItems = $getSourceItems;
        $this->getStockItemConfiguration = $getStockItemConfiguration;
        $this->getProductTypesBySkus = $getProductTypesBySkus;
        $this->isSourceItemManagementAllowedForProductType = $isSourceItemManagementAllowedForProductType;
    }

    /**
     * Execute
     * 
     * @param string $sku
     * @param string $sourceCode
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(string $sku, string $sourceCode): float
    {
        $this->validateProductType($sku);
        $stockId = $this->getStockIdBySourceCode->execute($sourceCode);
        $sourceItem = $this->getSourceItems->execute($sku, $stockId)[$sourceCode] ?? null;
        if (!$sourceItem || !$sourceItem->isSalable()) {
            return 0;
        }
        $stockItemConfig = $this->getStockItemConfiguration->execute($sku, $sourceCode);
        $qty = $sourceItem->getQuantity();
        $reservationQty = $this->getReservationsQuantity->execute($sku, $sourceCode);
        $minQty = $stockItemConfig->getMinQty();
        return $qty + $reservationQty - $minQty;
    }

    /**
     * Validate product type
     * 
     * @param string $sku
     * @return bool
     * @throws \Magento\Framework\Exception\InputException
     */
    private function validateProductType(string $sku): bool
    {
        $productTypes = $this->getProductTypesBySkus->execute([$sku]);
        if (!array_key_exists($sku, $productTypes)) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('The product that was requested doesn\'t exist. Verify the product and try again.')
            );
        }
        $productType = $productTypes[$sku];
        if (false === $this->isSourceItemManagementAllowedForProductType->execute($productType)) {
            throw new \Magento\Framework\Exception\InputException(
                __('Can\'t check requested quantity for products without source items support.')
            );
        }
        return true;
    }
}