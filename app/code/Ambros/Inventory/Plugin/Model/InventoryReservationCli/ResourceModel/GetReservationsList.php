<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservationCli\ResourceModel;

/**
 * Get reservations list plugin
 */
class GetReservationsList
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
     * @param \Magento\InventoryReservationCli\Model\ResourceModel\GetReservationsList $subject
     * @param callable $proceed
     * @return array
     */
    public function aroundExecute(
        \Magento\InventoryReservationCli\Model\ResourceModel\GetReservationsList $subject,
        callable $proceed
    ): array
    {
        $connection = $this->connectionProvider->getConnection();
        return $connection->fetchAll(
            $connection->select()
                ->from($this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation'))
        );
    }
}