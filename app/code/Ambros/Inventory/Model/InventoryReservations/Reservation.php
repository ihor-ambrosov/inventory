<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservations;

/**
 * Reservation
 */
class Reservation extends \Magento\InventoryReservations\Model\Reservation 
    implements \Ambros\Inventory\Model\InventoryReservations\ReservationInterface 
{
    /**
     * Source code
     * 
     * @var string
     */
    private $sourceCode;

    /**
     * Constructor
     * 
     * @param int|null $reservationId
     * @param string $sourceCode
     * @param string $sku
     * @param float $quantity
     * @param null $metadata
     * @return void
     */
    public function __construct(
        $reservationId,
        string $sourceCode,
        string $sku,
        float $quantity,
        $metadata = null
    )
    {
        parent::__construct($reservationId, 0, $sku, $quantity, $metadata);
        $this->sourceCode = $sourceCode;
    }

    /**
     * Get source code
     * 
     * @return string
     */
    public function getSourceCode(): string
    {
        return $this->sourceCode;
    }
}