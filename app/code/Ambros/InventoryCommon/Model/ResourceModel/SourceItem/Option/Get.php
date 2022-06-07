<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option;

/**
 * Get source item options resource
 */
class Get
{
    /**
     * Connection provider
     * 
     * @var \Ambros\Common\Model\ResourceModel\ConnectionProvider
     */
    private $connectionProvider;

    /**
     * Table name
     * 
     * @var string
     */
    private $tableName;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider
     * @param string $tableName
     * @return void
     */
    public function __construct(
        \Ambros\Common\Model\ResourceModel\ConnectionProvider $connectionProvider,
        string $tableName
    )
    {
        $this->connectionProvider = $connectionProvider;
        $this->tableName = $tableName;
    }
    
    /**
     * Execute
     * 
     * @param array $skus
     * @param array|null $sourceCodes
     * @return array
     */
    public function execute(array $skus, array $sourceCodes = null): array
    {
        $select = $this->connectionProvider->getSelect()
            ->from($this->connectionProvider->getTable($this->tableName))
            ->where(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU.' IN (?)', $skus)
            ->where(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE.' IS NOT NULL');
        if ($sourceCodes !== null) {
            $select->where(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE.' IN (?)', $sourceCodes);
        }
        return $this->connectionProvider->getConnection()->fetchAll($select);
    }
}