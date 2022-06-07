<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Framework\ResourceModel\Collection;

/**
 * Collection source wrapper
 */
class Source extends \Ambros\Common\DataObject\Wrapper
{
    /**
     * Source table
     * 
     * @var string
     */
    private $sourceTable;

    /**
     * Constructor
     * 
     * @param \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory
     * @param string $sourceTable
     * @return void
     */
    public function __construct(
        \Ambros\Common\DataObject\ReflectionFactory $objectReflectionFactory,
        string $sourceTable
    )
    {
        parent::__construct($objectReflectionFactory);
        $this->sourceTable = $sourceTable;
    }

    /**
     * Get source codes
     * 
     * @param array $modelIds
     * @return array
     */
    public function getSourceCodes(array $modelIds): array
    {
        $collection = $this->getObject();
        if (empty($modelIds)) {
            return [];
        }
        $connection = $collection->getConnection();
        $idFieldName = $collection->getResource()->getIdFieldName();
        $select = $connection->select()
            ->from($collection->getTable($this->sourceTable))
            ->where($idFieldName.' IN (?)', $modelIds);
        $sourceCodesData = $connection->fetchAll($select);
        $sourceCodes = [];
        if (!empty($sourceCodesData)) {
            foreach ($sourceCodesData as $sourceCodeData) {
                $modelId = $sourceCodeData[$idFieldName];
                $sourceCodes[$modelId] = $sourceCodeData['source_code'];
            }
        }
        return $sourceCodes;
    }
}