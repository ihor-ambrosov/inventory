<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\Inventory;

/**
 * Get legacy stock item
 */
class GetLegacyStockItem
{
    /**
     * Get stock ID by store
     * 
     * @var \Ambros\InventoryCommon\Api\GetStockIdByStoreInterface 
     */
    private $getStockIdByStore;

    /**
     * Get enabled source codes by stock ID
     * 
     * @var type 
     */
    private $getEnabledSourceCodesByStockId;
    
    /**
     * Stock registry
     * 
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    private $stockRegistry;

    /**
     * Module manager
     * 
     * @var \Magento\Framework\Module\Manager
     */
    private $moduleManager;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\GetStockIdByStoreInterface $getStockIdByStore
     * @param \Ambros\InventoryCommon\Model\GetEnabledSourceCodesByStockId $getEnabledSourceCodesByStockId
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param \Magento\Framework\Module\Manager $moduleManager
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\GetStockIdByStoreInterface $getStockIdByStore,
        \Ambros\InventoryCommon\Model\GetEnabledSourceCodesByStockId $getEnabledSourceCodesByStockId,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Framework\Module\Manager $moduleManager
    )
    {
        $this->getStockIdByStore = $getStockIdByStore;
        $this->getEnabledSourceCodesByStockId = $getEnabledSourceCodesByStockId;
        $this->stockRegistry = $stockRegistry;
        $this->moduleManager = $moduleManager;
    }
    
    /**
     * Execute
     * 
     * @param \Magento\Catalog\Api\Data\ProductInterface $product
     * @param \Magento\Store\Api\Data\StoreInterface|null $store
     * @return \Magento\CatalogInventory\Api\Data\StockItemInterface
     */
    public function execute(
        \Magento\Catalog\Api\Data\ProductInterface $product,
        \Magento\Store\Api\Data\StoreInterface $store = null
    ): \Magento\CatalogInventory\Api\Data\StockItemInterface
    {
        if ($store === null) {
            $store = $product->getStore();
        }
        $stockItem = $this->stockRegistry->getStockItem($product->getId(), $store->getWebsiteId());
        if (!$this->moduleManager->isEnabled('Ambros_InventoryCatalog')) {
            return $stockItem;
        }
        $stockItemExtension = $stockItem->getExtensionAttributes();
        $stockItemExtension->setProductSku($product->getData(\Magento\Catalog\Api\Data\ProductInterface::SKU));
        $sourceCode = (string) $product->getSourceCode();
        if ($sourceCode) {
            $stockItemExtension->setSourceCodes([$sourceCode]);
            return $stockItem;
        }
        if ((int) $store->getId() === \Magento\Store\Model\Store::DEFAULT_STORE_ID) {
            $stockItemExtension->setSourceCodes([]);
            return $stockItem;
        }
        $stockItemExtension->setSourceCodes($this->getEnabledSourceCodesByStockId->execute($this->getStockIdByStore->execute($store)));
        return $stockItem;
    }
}