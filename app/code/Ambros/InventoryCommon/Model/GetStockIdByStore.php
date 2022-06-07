<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get stock ID by store
 */
class GetStockIdByStore implements \Ambros\InventoryCommon\Api\GetStockIdByStoreInterface
{
    /**
     * Stock resolver
     * 
     * @var \Ambros\InventoryCommon\Api\GetStockByStoreInterface
     */
    private $getStockByStore;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Api\GetStockByStoreInterface $getStockByStore
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Api\GetStockByStoreInterface $getStockByStore
    )
    {
        $this->getStockByStore = $getStockByStore;
    }
    
    /**
     * Execute
     * 
     * @param null|string|bool|int|\Magento\Store\Api\Data\StoreInterface $store
     * @return int
     */
    public function execute($store = null): int
    {
        return (int) $this->getStockByStore->execute($store)->getStockId();
    }
}