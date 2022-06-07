<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservations\ResourceModel;

/**
 * Save multiple reservations resource plugin
 */
class SaveMultiple
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;
    
    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
    )
    {
        $this->connectionProvider = $connectionProvider;
    }
    
    /**
     * Around execute
     * 
     * @param \Magento\InventoryReservations\Model\ResourceModel\SaveMultiple $subject
     * @param \Closure $proceed
     * @param \Ambros\Inventory\Model\InventoryReservations\ReservationInterface[] $reservations
     * @return void
     */
    public function aroundExecute(
        \Magento\InventoryReservations\Model\ResourceModel\SaveMultiple $subject,
        \Closure $proceed,
        array $reservations
    )
    {
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                $reservation->getSourceCode(),
                $reservation->getSku(),
                $reservation->getQuantity(),
                $reservation->getMetadata(),
            ];
        }
        $this->connectionProvider->getConnection()->insertArray(
            $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation'),
            [
                \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SOURCE_CODE,
                \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SKU,
                \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::QUANTITY,
                \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::METADATA,
            ], 
            $data
        );
    }
}