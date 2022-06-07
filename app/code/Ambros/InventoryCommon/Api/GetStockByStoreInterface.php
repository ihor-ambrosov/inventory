<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api;

/**
 * Get stock by store interface
 */
interface GetStockByStoreInterface
{
    /**
     * Execute
     * 
     * @param null|string|bool|int|\Magento\Store\Api\Data\StoreInterface $store
     * @return \Magento\InventoryApi\Api\Data\StockInterface
     */
    public function execute($store = null): \Magento\InventoryApi\Api\Data\StockInterface;
}