<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryInStorePickupShippingApi\Carrier;

/**
 * In store pickup carrier plugin
 */
class InStorePickup
{
    /**
     * Around is active
     * 
     * @param \Magento\InventoryInStorePickupShippingApi\Model\Carrier\InStorePickup $subject
     * @param callable $proceed
     * @return bool
     */
    public function aroundIsActive(
        \Magento\InventoryInStorePickupShippingApi\Model\Carrier\InStorePickup $subject,
        callable $proceed
    )
    {
        return false;
    }
}