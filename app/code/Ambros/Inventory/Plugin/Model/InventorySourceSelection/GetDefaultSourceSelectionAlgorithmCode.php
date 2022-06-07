<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventorySourceSelection;

/**
 * Get default source selection algorithm code plugin
 */
class GetDefaultSourceSelectionAlgorithmCode
{
    /**
     * Around execute
     * 
     * @param \Magento\InventorySourceSelection\Model\GetDefaultSourceSelectionAlgorithmCode
     * @param \Closure $proceed
     * @return string
     */
    public function aroundExecute(
        \Magento\InventorySourceSelection\Model\GetDefaultSourceSelectionAlgorithmCode $subject,
        \Closure $proceed
    ) : string
    {
        return 'default';
    }
}