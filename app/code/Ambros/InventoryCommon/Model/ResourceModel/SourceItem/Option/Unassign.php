<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option;

/**
 * Un-assign source item options resource
 */
class Unassign
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
     * @param array $sources
     * @return $this
     */
    public function execute(array $skus, array $sources) {
        $connection = $this->connectionProvider->getConnection();
        $connection->delete(
            $this->connectionProvider->getTable($this->tableName),
            $this->connectionProvider->getCondition([
                $connection->quoteInto(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU.' IN (?)', $skus),
                $connection->quoteInto(\Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE.' IN (?)', $sources),
            ], 'AND')
        );
        return $this;
    }
}
