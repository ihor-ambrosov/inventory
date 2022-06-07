<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option;

/**
 * Save source item options resource
 */
class Save
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
        if (!count($options)) {
            return $this;
        }
        $optionsData = [];
        foreach ($options as $option) {
            $optionsData[] = [
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SOURCE_CODE => $option->getSourceCode(),
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::SKU => $option->getSku(),
                \Ambros\InventoryCommon\Api\Data\SourceItemOptionInterface::VALUE => $option->getValue(),
            ];
        }
        $this->connectionProvider->getConnection()->insertOnDuplicate(
            $this->connectionProvider->getTable($this->tableName),
            $optionsData
        );
        return $this;
    }
}
