<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Plugin\Model\InventoryReservationCli\SalableQuantityInconsistency;

/**
 * Filter managed stock products plugin
 */
class FilterManagedStockProducts
{
    /**
     * Is product assigned to source
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\IsProductAssignedToSource
     */
    private $isProductAssignedToSource;

    /**
     * Get stock item configuration
     * 
     * @var \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration
     */
    private $getStockItemConfiguration;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\IsProductAssignedToSource $isProductAssignedToSource
     * @param \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\IsProductAssignedToSource $isProductAssignedToSource,
        \Ambros\Inventory\Model\Inventory\GetStockItemConfiguration $getStockItemConfiguration
    )
    {
        $this->isProductAssignedToSource = $isProductAssignedToSource;
        $this->getStockItemConfiguration = $getStockItemConfiguration;
    }

    /**
     * Around execute
     * 
     * @param \Magento\InventoryReservationCli\Model\SalableQuantityInconsistency\FilterManagedStockProducts $subject
     * @param callable $proceed
     * @param \Ambros\Inventory\Model\InventoryReservationCli\SalableQuantityInconsistency[] $inconsistencies
     * @return \Ambros\Inventory\Model\InventoryReservationCli\SalableQuantityInconsistency[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function aroundExecute(
        \Magento\InventoryReservationCli\Model\SalableQuantityInconsistency\FilterManagedStockProducts $subject,
        callable $proceed,
        array $inconsistencies
    ): array
    {
        foreach ($inconsistencies as $inconsistency) {
            $filteredItems = [];
            foreach ($inconsistency->getItems() as $sku => $qty) {
                $sourceCode = (string) $inconsistency->getSourceCode();
                if (false === $this->isProductAssignedToSource->execute((string) $sku, $sourceCode)) {
                    continue;
                }
                $stockConfiguration = $this->getStockItemConfiguration->execute((string) $sku, $sourceCode);
                if (!$stockConfiguration->isManageStock()) {
                    continue;
                }
                $filteredItems[$sku] = $qty;
            }
            $inconsistency->setItems($filteredItems);
        }
        return $inconsistencies;
    }
}