<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventorySales\ResourceModel;

/**
 * Delete reservations by SKUs plugin
 */
class DeleteReservationsBySkus
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
     * @param \Magento\InventorySales\Model\ResourceModel\DeleteReservationsBySkus $subject
     * @param callable $proceed
     * @param array $skus
     * @return void
     */
    public function aroundExecute(
        \Magento\InventorySales\Model\ResourceModel\DeleteReservationsBySkus $subject,
        callable $proceed,
        array $skus
    ): void
    {
        $connection = $this->connectionProvider->getConnection();
        $connection->delete(
            $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation'),
            $connection->quoteInto('sku IN (?)', $skus)
        );
    }
}