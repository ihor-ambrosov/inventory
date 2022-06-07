<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model;

/**
 * Get enabled source codes by stock ID
 */
class GetEnabledSourceCodesByStockId
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
     * Execute
     * 
     * @param int $stockId
     * @return array
     */
    public function execute(int $stockId): array
    {
        $connection = $this->connectionProvider->getConnection();
        return $connection->fetchCol(
            $connection->select()
                ->from(
                    ['source' => $this->connectionProvider->getTable(\Magento\Inventory\Model\ResourceModel\Source::TABLE_NAME_SOURCE)],
                    [\Magento\InventoryApi\Api\Data\SourceInterface::SOURCE_CODE]
                )
                ->joinInner(
                    ['stock_source_link' => $this->connectionProvider->getTable(\Magento\Inventory\Model\ResourceModel\StockSourceLink::TABLE_NAME_STOCK_SOURCE_LINK)],
                    'source.'.\Magento\InventoryApi\Api\Data\SourceItemInterface::SOURCE_CODE.' = stock_source_link.'.\Magento\InventoryApi\Api\Data\StockSourceLinkInterface::SOURCE_CODE,
                    []
                )
                ->where('stock_source_link.'.\Magento\InventoryApi\Api\Data\StockSourceLinkInterface::STOCK_ID.' = ?', $stockId)
                ->where(\Magento\InventoryApi\Api\Data\SourceInterface::ENABLED . ' = ?', 1)
        );
    }
}