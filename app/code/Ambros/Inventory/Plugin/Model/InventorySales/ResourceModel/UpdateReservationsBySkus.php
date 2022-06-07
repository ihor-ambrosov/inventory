<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventorySales\ResourceModel;

/**
 * Update reservations by SKUs plugin
 */
class UpdateReservationsBySkus
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
     * @param \Magento\InventorySales\Model\ResourceModel\UpdateReservationsBySkus $subject
     * @param callable $proceed
     * @param array $skus
     * @return void
     */
    public function aroundExecute(
        \Magento\InventorySales\Model\ResourceModel\UpdateReservationsBySkus $subject,
        callable $proceed,
        array $skus
    ): void
    {
        foreach ($skus as $sku) {
            $connection = $this->connectionProvider->getConnection();
            $connection->update(
                $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation'),
                [ 'sku' => $sku->getNew() ],
                [ 'sku = ?' => $sku->getOld() ]
            );
        }
    }
}