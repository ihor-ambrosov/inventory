<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Api;

/**
 * Current stock provider interface
 */
interface CurrentStockProviderInterface
{
    /**
     * Get ID
     * 
     * @param int|null $storeId
     * @return int
     */
    public function getId(int $storeId = null): int;
}