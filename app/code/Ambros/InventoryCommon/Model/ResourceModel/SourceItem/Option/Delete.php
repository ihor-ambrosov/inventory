<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option;

/**
 * Delete source item options resource
 */
class Delete
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
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[] $options
     * @return $this
     */
    public function execute(array $options)
    {
        if (empty($options)) {
            return $this;
        }
        $this->connectionProvider->getConnection()->delete(
            $this->connectionProvider->getTable($this->tableName),
            $this->getWhereSql($options)
        );
        return $this;
    }

    /**
     * Get where SQL
     *
     * @param \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface[] $options
     * @return string
     */
    private function getWhereSql(array $options): string
    {
        $connection = $this->connectionProvider->getConnection();
        $subConditions = [];
        foreach ($options as $option) {
            $subConditions[] = $this->connectionProvider->getCondition([
                $connection->quoteInto(
                    \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU.' = ?',
                    $option->getSku()
                ),
                $connection->quoteInto(
                    \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE.' = ?',
                    $option->getSourceCode()
                ),
            ], 'AND');
        }
        return $this->connectionProvider->getCondition($subConditions, 'OR');
    }
}