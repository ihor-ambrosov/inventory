<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservations\ResourceModel;

/**
 * Cleanup reservations resource plugin
 */
class CleanupReservations extends \Ambros\Common\Plugin\Plugin
{
    /**
     * $connectionProvider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\WrapperFactory $wrapperFactory
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\WrapperFactory $wrapperFactory,
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
    )
    {
        parent::__construct($wrapperFactory);
        $this->connectionProvider = $connectionProvider;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryReservations\Model\ResourceModel\CleanupReservations $subject
     * @param \Closure $proceed
     * @return void
     */
    public function aroundExecute(
        \Magento\InventoryReservations\Model\ResourceModel\CleanupReservations $subject,
        \Closure $proceed
    )
    {
        $this->setSubject($subject);
        $connection = $this->connectionProvider->getConnection();
        $table = $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation');
        $groupedReservationIds = implode(',', array_unique(array_merge($this->getReservationIdsByField('object_id'), $this->getReservationIdsByField('object_increment_id'))));
        $condition = [\Magento\InventoryReservationsApi\Model\ReservationInterface::RESERVATION_ID.' IN (?)' => explode(',', $groupedReservationIds)];
        $connection->delete($table, $condition);
    }

    /**
     * Get reservation IDs by field
     *
     * @param string $field
     * @return array
     */
    private function getReservationIdsByField(string $field) : array
    {
        $connection = $this->connectionProvider->getConnection();
        $table = $this->connectionProvider->getTable('ambros_inventory__source_inventory_reservation');
        $select = $connection->select()
            ->from($table, ['GROUP_CONCAT('.\Magento\InventoryReservationsApi\Model\ReservationInterface::RESERVATION_ID.')'])
            ->group("JSON_EXTRACT(metadata, '$.$field')", "JSON_EXTRACT(metadata, '$.object_type')")
            ->having('SUM('.\Magento\InventoryReservationsApi\Model\ReservationInterface::QUANTITY.') = 0');
        $connection->query('SET group_concat_max_len = ' . $this->getSubjectPropertyValue('groupConcatMaxLen'));
        return $connection->fetchCol($select);
    }
}