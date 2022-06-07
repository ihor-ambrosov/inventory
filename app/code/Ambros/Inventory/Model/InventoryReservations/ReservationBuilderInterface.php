<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservations;

/**
 * Reservation builder interface
 */
interface ReservationBuilderInterface extends \Magento\InventoryReservationsApi\Model\ReservationBuilderInterface
{
    /**
     * Set source code
     * 
     * @param string $sourceCode
     * @return \Magento\InventoryReservationsApi\Model\ReservationBuilderInterface
     */
    public function setSourceCode(string $sourceCode): \Magento\InventoryReservationsApi\Model\ReservationBuilderInterface;
}
