<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservations\ResourceModel;

/**
 * Get reservations quantity resource plugin
 */
class GetReservationsQuantity
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;

    /**
     * Get enabled sources by stock ID
     * 
     * @var \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId
     */
    private $getEnabledSourcesByStockId;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId $getEnabledSourcesByStockId
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        \Ambros\InventoryCommon\Model\GetEnabledSourcesByStockId $getEnabledSourcesByStockId
    )
    {
        $this->connectionProvider = $connectionProvider;
        $this->getEnabledSourcesByStockId = $getEnabledSourcesByStockId;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryReservations\Model\ResourceModel\GetReservationsQuantity $subject
     * @param \Closure $proceed
     * @param string $sku
     * @param int $stockId
     * @return float
     */
    public function aroundExecute(
        \Magento\InventoryReservations\Model\ResourceModel\GetReservationsQuantity $subject,
        \Closure $proceed,
        string $sku,
        int $stockId
    ): float
    {
        $connection = $this->connectionProvider->getConnection();
        $table = $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation');
        $quantity = \Ambros\Inventory\Model\InventoryReservations\ReservationInterface::QUANTITY;
        $sources = $this->getEnabledSourcesByStockId->execute($stockId);
        $select = $connection->select()
            ->from($table, [$quantity => 'SUM('.$quantity.')'])
            ->where(\Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SKU . ' = ?', $sku)
            ->where(\Ambros\Inventory\Model\InventoryReservations\ReservationInterface::SOURCE_CODE . ' IN (?)', array_keys($sources))
            ->limit(1);
        $qty = $connection->fetchOne($select);
        return ($qty !== false) ? (float) $qty : 0;
    }
}