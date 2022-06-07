<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Api\Catalog\Product;

/**
 * Product source quote management interface
 */
interface SourceQuoteManagementInterface
{
    /**
     * Get list
     * 
     * @param string $sku
     * @param \Magento\Quote\Api\Data\AddressInterface $address
     * @param mixed $request
     * @return \Ambros\Inventory\Api\Catalog\Data\Product\SourceQuoteInterface[]
     */
    public function getList($sku, $address, $request = []);
}