<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Api\InventorySales;

/**
 * Get product salable qty interface
 */
interface GetProductSalableQtyInterface
{
    /**
     * Execute
     * 
     * @param string $sku
     * @param string $sourceCode
     * @return float
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(string $sku, string $sourceCode): float;
}