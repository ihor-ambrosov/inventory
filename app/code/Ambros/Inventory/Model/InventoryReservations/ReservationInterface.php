<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservations;

/**
 * Reservation interface
 */
interface ReservationInterface extends \Magento\InventoryReservationsApi\Model\ReservationInterface
{
    /**
     * Source code key
     */
    const SOURCE_CODE = 'source_code';

    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string;
}