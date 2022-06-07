<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservations\ResourceModel;

/**
 * Get reservations quantity
 */
class GetReservationsQuantity implements \Ambros\Inventory\Model\InventoryReservations\GetReservationsQuantityInterface
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
     * Execute
     *
     * @param string $sku
     * @param string $sourceCode
     * @return float
     */
    public function execute(string $sku, string $sourceCode): float
    {
        $connection = $this->connectionProvider->getConnection();
        $reservationTable = $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation');
        $quantity = \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::QUANTITY;
        $select = $connection->select();
        $select->from($reservationTable, [$quantity => 'SUM('.$quantity.')']);
        $select->where(\Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SKU . ' = ?', $sku);
        $select->where(\Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SOURCE_CODE . ' = ?', $sourceCode);
        $select->limit(1);
        $qty = $connection->fetchOne($select);
        return ($qty !== false) ? (float) $qty : 0;
    }
}