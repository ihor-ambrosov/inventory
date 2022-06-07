<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservationsApi;

/**
 * Append reservations interface plugin
 */
class AppendReservationsInterface
{
    /**
     * Get stock item configuration
     * 
     * @var \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration
     */
    private $getStockItemConfiguration;

    /**
     * Stock configuration
     * 
     * @var \Magento\CatalogInventory\Api\StockConfigurationInterface
     */
    private $stockConfiguration;

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
     * @param \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration,
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration
    )
    {
        $this->getStockItemConfiguration = $getStockItemConfiguration;
        $this->stockConfiguration = $stockConfiguration;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryReservationsApi\Model\AppendReservationsInterface $subject
     * @param \Closure $proceed
     * @param \Ambros\Inventory\Model\InventoryReservations\ReservationInterface[] $reservations
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundExecute(
        \Magento\InventoryReservationsApi\Model\AppendReservationsInterface $subject,
        \Closure $proceed,
        array $reservations
    )
    {
        if (!$this->stockConfiguration->canSubtractQty()) {
            return;
        }
        $reservationToAppend = [];
        foreach ($reservations as $reservation) {
            $stockItemConfiguration = $this->getStockItemConfiguration->execute($reservation->getSku(), (string) $reservation->getSourceCode());
            if ($stockItemConfiguration->isManageStock()) {
                $reservationToAppend[] = $reservation;
            }
        }
        if (!empty($reservationToAppend)) {
            $proceed($reservationToAppend);
        }
    }
}