<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventoryReservations;

/**
 * Get reservations quantity interface
 */
interface GetReservationsQuantityInterface
{
    /**
     * Execute
     *
     * @param string $sku
     * @param string $sourceCode
     * @return float
     */
    public function execute(string $sku, string $sourceCode): float;
}