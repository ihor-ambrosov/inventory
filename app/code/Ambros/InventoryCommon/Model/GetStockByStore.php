<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get stock by store
 */
class GetStockByStore implements \Ambros\InventoryCommon\Api\GetStockByStoreInterface
{
    /**
     * Get default stock
     * 
     * @var \Ambros\InventoryCommon\Api\GetDefaultStockInterface
     */
    private $getDefaultStock;

    /**
     * Stock resolver
     * 
     * @var \Magento\InventorySalesApi\Api\StockResolverInterface
     */
    private $stockResolver;

    /**
     * Store manager
     * 
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\GetDefaultStockInterface $getDefaultStock
     * @param \Magento\InventorySalesApi\Api\StockResolverInterface $stockResolver
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\GetDefaultStockInterface $getDefaultStock,
        \Magento\InventorySalesApi\Api\StockResolverInterface $stockResolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->getDefaultStock = $getDefaultStock;
        $this->stockResolver = $stockResolver;
        $this->storeManager = $storeManager;
    }

    /**
     * Execute
     * 
     * @param null|string|bool|int|\Magento\Store\Api\Data\StoreInterface $store
     * @return \Magento\InventoryApi\Api\Data\StockInterface
     */
    public function execute($store = null): \Magento\InventoryApi\Api\Data\StockInterface
    {
        try {
            $stock = $this->stockResolver->execute(
                \Magento\InventorySalesApi\Api\Data\SalesChannelInterface::TYPE_WEBSITE,
                $this->storeManager->getStore($store)->getWebsite()->getCode()
            );
        } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
            $stock = $this->getDefaultStock->execute();
        }
        return $stock;
    }
}