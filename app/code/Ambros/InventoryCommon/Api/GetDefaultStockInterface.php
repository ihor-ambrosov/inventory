<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api;

/**
 * Get default stock interface
 */
interface GetDefaultStockInterface
{
    /**
     * Execute
     * 
     * @return \Magento\InventoryApi\Api\Data\StockInterface
     */
    public function execute(): \Magento\InventoryApi\Api\Data\StockInterface;
}