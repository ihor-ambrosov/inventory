<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Model\InventorySales;

/**
 * Get salable source items
 */
class GetSalableSourceItems
{
    /**
     * Get source items
     * 
     * @var \Ambros\Inventory\Model\InventorySales\GetSourceItems
     */
    private $getSourceItems;

    /**
     * Source items
     * 
     * @var \Ambros\Inventory\Model\InventorySales\SourceItemInterface[][]
     */
    private $sourceItems = [];

    /**
     * Constructor
     * 
     * @param \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems
     * @return void
     */
    public function __construct(
        \Ambros\Inventory\Model\InventorySales\GetSourceItems $getSourceItems
    )
    {
        $this->getSourceItems = $getSourceItems;
    }

    /**
     * Execute
     * 
     * @param string $sku
     * @param int $stockId
     * @return \Ambros\Inventory\Model\InventorySales\SourceItemInterface[]
     */
    public function execute(string $sku, int $stockId): array
    {
        if (
            array_key_exists($sku, $this->sourceItems) && 
            array_key_exists($stockId, $this->sourceItems[$sku])
        ) {
            return $this->sourceItems[$sku][$stockId];
        }
        $sourceItems = $this->getSourceItems->execute($sku, $stockId);
        $salableSourceItems = [];
        foreach ($sourceItems as $sourceCode => $sourceItem) {
            if ($sourceItem->isSalable()) {
                $salableSourceItems[$sourceCode] = $sourceItem;
            }
        }
        return $this->sourceItems[$sku][$stockId] = $salableSourceItems;
    }
}