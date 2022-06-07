<?php
/**
 * @author Ihor Ambrosov <ihor.ambrosov@gmail.com>
 * @license https://opensource.org/licenses/OSL-3.0
 */
declare(strict_types=1);

namespace Ambros\InventoryCommon\Plugin\Api\InventoryCatalogApi;

/**
 * Bulk source unassign interface
 */
class BulkSourceUnassignInterface
{
    /**
     * Unassign source item options
     * 
     * @var \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign
     */
    private $unassignSourceItemOptions;

    /**
     * Source item option configuration
     * 
     * @var \Ambros\InventoryCommon\Model\SourceItem\Option\Config
     */
    private $optionConfig;

    /**
     * Constructor
     * 
     * @param \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign $unassignSourceItemOptions
     * @param \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
     * @return void
     */
    public function __construct(
        \Ambros\InventoryCommon\Model\ResourceModel\SourceItem\Option\Unassign $unassignSourceItemOptions,
        \Ambros\InventoryCommon\Model\SourceItem\Option\Config $optionConfig
    )
    {
        $this->unassignSourceItemOptions = $unassignSourceItemOptions;
        $this->optionConfig = $optionConfig;
    }

    /**
     * After execute
     *
     * @param \Magento\InventoryCatalogApi\Api\BulkSourceUnassignInterface $subject
     * @param int $result
     * @param array $skus
     * @param array $sources
     * @return int
     */
    public function afterExecute(
        \Magento\InventoryCatalogApi\Api\BulkSourceUnassignInterface $subject,
        int $result,
        array $skus,
        array $sources
    ): int
    {
        if ($this->optionConfig->isEnabled()) {
            $this->unassignSourceItemOptions->execute($skus, $sources);
        }
        return $result;
    }
}