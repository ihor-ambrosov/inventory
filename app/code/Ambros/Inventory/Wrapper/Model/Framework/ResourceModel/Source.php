<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\Inventory\Wrapper\Model\Framework\ResourceModel;

/**
 * Resource source wrapper
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
     * Get source code
     * 
     * @param mixed $modelId
     * @return string|null
     */
    public function getSourceCode($modelId): ?string
    {
        if (empty($modelId)) {
            return null;
        }
        $resource = $this->getObject();
        $connection = $resource->getConnection();
        $select = $connection->select()
            ->from($resource->getTable($this->sourceTable), ['source_code'])
            ->where($resource->getIdFieldName().' = ?', $modelId);
        $sourceCode = $connection->fetchOne($select);
        return $sourceCode ? (string) $sourceCode : null;
    }
    
    /**
     * Delete source code
     * 
     * @param mixed $modelId
     * @return void
     */
    public function deleteSourceCode($modelId): void
    {
        if (empty($modelId)) {
            return;
        }
        $resource = $this->getObject();
        $resource->getConnection()->delete($resource->getTable($this->sourceTable), [$resource->getIdFieldName().' = ?' => $modelId]);
    }
    
    /**
     * Save source code
     * 
     * @param mixed $modelId
     * @param string $sourceCode
     * @return void
     */
    public function saveSourceCode($modelId, string $sourceCode): void
    {
        if (empty($modelId)) {
            return;
        }
        $resource = $this->getObject();
        $connection = $resource->getConnection();
        if (empty($sourceCode)) {
            $this->deleteSourceCode($modelId);
            return;
        }
        $origSourceCode = $this->getSourceCode($modelId);
        if (empty($origSourceCode)) {
            $connection->insert(
                $resource->getTable($this->sourceTable),
                [
                    $resource->getIdFieldName() => $modelId,
                    'source_code' => $sourceCode,
                ]
            );
            return;
        }
        if ($origSourceCode !== $sourceCode) {
            $connection->update(
                $resource->getTable($this->sourceTable),
                [ 'source_code' => $sourceCode ],
                [ $resource->getIdFieldName().' = ?' => $modelId ]
            );
        }
    }
}