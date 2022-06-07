<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Api\SourceItem\Option;

/**
 * Save source item options interface plugin
 */
class SaveInterface
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;
    
    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;
    
    /**
     * Source item option meta
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Meta
     */
    private $optionMeta;
    
    /**
     * Default source provider
     * 
     * @var \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface
     */
    private $defaultSourceProvider;
    
    /**
     * Default stock provider
     * 
     * @var \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface
     */
    private $defaultStockProvider;
    
    /**
     * Is single source mode
     * 
     * @var \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface 
     */
    private $isSingleSourceMode;
    
    /**
     * Get product IDs by SKUs
     * 
     * @var \Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface
     */
    private $getProductIdsBySkus;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta
     * @param \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider
     * @param \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface $defaultStockProvider
     * @param \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode
     * @param \Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface $getProductIdsBySkus
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Meta $optionMeta,
        \Magento\InventoryCatalogApi\Api\DefaultSourceProviderInterface $defaultSourceProvider,
        \Magento\InventoryCatalogApi\Api\DefaultStockProviderInterface $defaultStockProvider,
        \Magento\InventoryCatalogApi\Model\IsSingleSourceModeInterface $isSingleSourceMode,
        \Magento\InventoryCatalogApi\Model\GetProductIdsBySkusInterface $getProductIdsBySkus
    )
    {
        $this->connectionProvider = $connectionProvider;
        $this->optionConfig = $optionConfig;
        $this->optionMeta = $optionMeta;
        $this->defaultSourceProvider = $defaultSourceProvider;
        $this->defaultStockProvider = $defaultStockProvider;
        $this->isSingleSourceMode = $isSingleSourceMode;
        $this->getProductIdsBySkus = $getProductIdsBySkus;
    }
    
    /**
     * After execute
     * 
     * @param \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $subject
     * @param $result
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[] $options
     * @return \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
     */
    public function afterExecute(
        \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface $subject,
        $result,
        array $options
    ): \Ambros\InventoryCommon\Api\SourceItem\Option\SaveInterface
    {
        if (!$this->optionConfig->isEnabled() || $this->isSingleSourceMode->execute()) {
            return $result;
        }
        $stockItemsData = [];
        $optionName = $this->optionMeta->getName();
        foreach ($options as $option) {
            if ($option->getSourceCode() !== $this->defaultSourceProvider->getCode()) {
                continue;
            }
            $optionValue = $option->getValue();
            $stockItemsData[$option->getSku()] = [
                \Magento\CatalogInventory\Api\Data\StockItemInterface::STOCK_ID => $this->defaultStockProvider->getId(),
                'use_config_'.$optionName => $optionValue !== null ? 0 : 1,
                $optionName => $optionValue ?? 0,
            ];
        }
        if (empty($stockItemsData)) {
            return $result;
        }
        $productIds = $this->getProductIdsBySkus->execute(array_keys($stockItemsData));
        foreach ($stockItemsData as $sku => &$stockItemData) {
            if (!empty($productIds[$sku])) {
                $stockItemData[\Magento\CatalogInventory\Api\Data\StockItemInterface::PRODUCT_ID] = $productIds[$sku];
            } else {
                unset($stockItemsData[$sku]);
            }
        }
        $this->connectionProvider->getConnection()->insertOnDuplicate(
            $this->connectionProvider->getTable('cataloginventory_stock_item'),
            $stockItemsData
        );
        return $result;
    }
}